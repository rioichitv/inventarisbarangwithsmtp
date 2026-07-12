<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;
        $level  = $request->level;

        $logs = ActivityLog::with('user')
            ->when($search, fn($q) => $q->where(function($q) use ($search) {
                $q->where('email', 'like', "%$search%")
                  ->orWhere('username', 'like', "%$search%")
                  ->orWhere('ip_address', 'like', "%$search%")
                  ->orWhere('activity_type', 'like', "%$search%");
            }))
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($level,  fn($q) => $q->where('level', $level))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('activity-log.index', compact('logs', 'search', 'status', 'level'));
    }

    public function destroy(ActivityLog $activityLog)
    {
        $activityLog->delete();
        return back()->with('success', 'Log berhasil dihapus!');
    }

    public function destroyAll()
    {
        ActivityLog::truncate();
        return back()->with('success', 'Semua log berhasil dihapus!');
    }
}
