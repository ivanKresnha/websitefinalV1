<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Eager load user terkait dengan activity logs
        $activityLogs = ActivityLog::with('user')->get(); // Ambil activity log beserta relasi user

        return view('dashboard.admin.log_aktivitas.index', compact('activityLogs'));
    }
}
