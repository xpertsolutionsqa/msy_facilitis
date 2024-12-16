<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Log;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function showLogs(Request $request)
    {
        $logs = Log::orderBy('created_at', 'desc')->paginate(20);
        return view('pages.logs', compact('logs'));
    }
    public function showdashboard(Request $request)
    {
        return view('pages.dashboard')->with([]);
    }
    public function showReports(Request $request)
    {
        return view('pages.reports.index');
    }
}
