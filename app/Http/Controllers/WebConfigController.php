<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class WebConfigController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->all();
        return view('settings.web-config', compact('settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'smtp_host'          => 'required|string',
            'smtp_port'          => 'required|integer',
            'smtp_username'      => 'nullable|string',
            'smtp_password'      => 'nullable|string',
            'smtp_encryption'    => 'required|string|in:none,tls,ssl',
            'smtp_from_address'  => 'required|email',
            'smtp_from_name'     => 'required|string',
        ]);

        Setting::setValue('smtp_host', $validated['smtp_host']);
        Setting::setValue('smtp_port', $validated['smtp_port']);
        Setting::setValue('smtp_username', $validated['smtp_username'] ?? '');
        Setting::setValue('smtp_password', $validated['smtp_password'] ?? '');
        Setting::setValue('smtp_encryption', $validated['smtp_encryption']);
        Setting::setValue('smtp_from_address', $validated['smtp_from_address']);
        Setting::setValue('smtp_from_name', $validated['smtp_from_name']);
        Setting::setValue('otp_login_enabled', $request->has('otp_login_enabled') ? '1' : '0');

        return back()->with('success', 'Konfigurasi web berhasil diperbarui!');
    }
}
