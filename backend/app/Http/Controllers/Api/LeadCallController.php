<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreLeadCallRequest;
use App\Models\Lead;
use App\Services\LeadCallService;
use Illuminate\Http\JsonResponse;

class LeadCallController extends Controller
{
    public function __construct(
        private readonly LeadCallService $leadCallService,
    ) {
    }

    public function store(StoreLeadCallRequest $request, Lead $lead): JsonResponse
    {
        $validated = $request->validated();

        $call = $this->leadCallService->create($lead, $validated);

        return response()->json($call, 201);
    }
}
