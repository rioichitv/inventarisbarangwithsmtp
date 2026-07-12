<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Setting;
use App\Mail\SendOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) return redirect()->route('dashboard');
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $otpEnabled = Setting::getValue('otp_login_enabled', '0') == '1';

            if ($otpEnabled) {
                // Generate OTP
                $otp = rand(100000, 999999);
                $user->otp_code = $otp;
                $user->otp_expires_at = now()->addMinutes(5);
                $user->save();

                // Kirim OTP via email
                try {
                    Mail::to($user->email)->send(new SendOtpMail($otp, $user->name));
                } catch (\Exception $e) {
                    return back()->withErrors(['email' => 'Gagal mengirim email OTP. Silakan periksa konfigurasi SMTP Anda: ' . $e->getMessage()])->onlyInput('email');
                }

                // Simpan user_id ke session untuk verifikasi OTP
                $request->session()->put('otp_user_id', $user->id);
                $request->session()->put('otp_remember', $request->boolean('remember'));

                return redirect()->route('login.otp');
            } else {
                // OTP tidak aktif, login langsung
                Auth::login($user, $request->boolean('remember'));
                $request->session()->regenerate();

                ActivityLog::create([
                    'user_id'       => $user->id,
                    'username'      => $user->name,
                    'email'         => $user->email,
                    'ip_address'    => $request->ip(),
                    'activity_type' => 'Login Admin',
                    'status'        => 'Success',
                    'level'         => 'Low',
                    'user_agent'    => $request->userAgent(),
                ]);

                return redirect()->intended(route('dashboard'));
            }
        }

        // Log gagal login
        ActivityLog::create([
            'user_id'       => null,
            'username'      => null,
            'email'         => $request->email,
            'ip_address'    => $request->ip(),
            'activity_type' => 'Login Admin',
            'status'        => 'Gagal',
            'level'         => 'Berisiko',
            'user_agent'    => $request->userAgent(),
        ]);

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function showOtp(Request $request)
    {
        if (!$request->session()->has('otp_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        if (!$request->session()->has('otp_user_id')) {
            return redirect()->route('login');
        }

        $userId = $request->session()->get('otp_user_id');
        $user = User::find($userId);

        if (!$user || $user->otp_code !== $request->otp || now()->gt($user->otp_expires_at)) {
            ActivityLog::create([
                'user_id'       => $userId,
                'username'      => $user ? $user->name : null,
                'email'         => $user ? $user->email : null,
                'ip_address'    => $request->ip(),
                'activity_type' => 'Verifikasi OTP',
                'status'        => 'Gagal',
                'level'         => 'Berisiko',
                'user_agent'    => $request->userAgent(),
            ]);

            return back()->withErrors(['otp' => 'OTP Anda salah atau telah kadaluarsa.']);
        }

        // OTP valid!
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        Auth::login($user, $request->session()->get('otp_remember', false));
        $request->session()->regenerate();
        $request->session()->forget(['otp_user_id', 'otp_remember']);

        ActivityLog::create([
            'user_id'       => $user->id,
            'username'      => $user->name,
            'email'         => $user->email,
            'ip_address'    => $request->ip(),
            'activity_type' => 'Login Admin',
            'status'        => 'Success',
            'level'         => 'Low',
            'user_agent'    => $request->userAgent(),
        ]);

        return redirect()->intended(route('dashboard'));
    }

    public function resendOtp(Request $request)
    {
        if (!$request->session()->has('otp_user_id')) {
            return redirect()->route('login');
        }

        $userId = $request->session()->get('otp_user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login');
        }

        $otp = rand(100000, 999999);
        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();

        try {
            Mail::to($user->email)->send(new SendOtpMail($otp, $user->name));
        } catch (\Exception $e) {
            return back()->withErrors(['otp' => 'Gagal mengirim ulang email OTP: ' . $e->getMessage()]);
        }

        return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        ActivityLog::create([
            'user_id'       => $user->id,
            'username'      => $user->name,
            'email'         => $user->email,
            'ip_address'    => $request->ip(),
            'activity_type' => 'Logout Admin',
            'status'        => 'Success',
            'level'         => 'Low',
            'user_agent'    => $request->userAgent(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
