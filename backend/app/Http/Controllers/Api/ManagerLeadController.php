<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Http\JsonResponse;

class ManagerLeadController extends Controller
{
    public function index(Manager $manager): JsonResponse
    {
        $leads = $manager->leads()
            ->select(['id', 'name', 'status'])
            ->withCount('calls')
            ->withSum('calls as total_call_duration', 'duration')
            ->get()
            ->map(fn ($lead) => [
                'id' => $lead->id,
                'name' => $lead->name,
                'status' => $lead->status,
                'calls_count' => $lead->calls_count,
                'total_call_duration' => (int) ($lead->total_call_duration ?? 0),
            ]);

        return response()->json($leads);
    }
}
