<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoggerController extends Controller
{
    public function getAllLogs()
    {
        $logs = Log::orderBy('arrival', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $logs,
            'count' => $logs->count()
        ]);
    }

    public function getLogsByName($name)
    {
        $logs = Log::where('name', $name)->orderBy('arrival', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $logs,
            'count' => $logs->count(),
            'name' => $name
        ]);
    }

    public function createLog(Request $request)
    {
        $name = trim($request->input('name'));
        $now = Carbon::now();

        // custom input validation 
        $validationErrors = Log::validateData(['name' => $name]);
        if (!empty($validationErrors)) {
            return response()->json([
                'success' => false,
                'errors' => $validationErrors
            ], 400);
        }

        // can't log after 20:00
        if ($now->hour >= 20) {
            return response()->json([
                'success' => false,
                'error' => 'Cannot log arrival after 20:00'
            ], 400);
        }

        // check for repeated log today
        $existingLog = Log::where('name', $name)
            ->whereDate('arrival', $now->toDateString())
            ->first();

        if ($existingLog) {
            return response()->json([
                'success' => false,
                'error' => 'Already logged arrival today',
                'existing_log' => $existingLog
            ], 400);
        }

        // check for late arrival
        $isLate = $now->hour > 8 || ($now->hour == 8 && $now->minute > 0);

        // log entry
        $log = Log::create([
            'name' => $name,
            'arrival' => $now,
            'late' => $isLate,
        ]);

        return response()->json([
            'success' => true,
            'data' => $log,
            'message' => $isLate ? 'Arrival logged (late)' : 'Arrival logged (on time)'
        ], 201);
    }
}
