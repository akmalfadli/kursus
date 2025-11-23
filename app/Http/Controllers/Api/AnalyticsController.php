<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AnalyticsController extends Controller
{
    public function track(Request $request)
    {
        $validated = $request->validate([
            'event_type' => 'required|string',
            'event_data' => 'nullable|array',
        ]);

        AnalyticsEvent::create([
            'event_type' => $validated['event_type'],
            'event_data' => $validated['event_data'],
            'session_id' => Session::getId(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json(['status' => 'success']);
    }
}
