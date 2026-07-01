<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreLeadRequest;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;

class LeadController extends Controller
{
    public function store(StoreLeadRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $lead = Lead::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'status' => Lead::STATUS_NEW,
            'manager_id' => $validated['manager_id'] ?? null,
        ]);

        return response()->json($lead, 201);
    }
}
