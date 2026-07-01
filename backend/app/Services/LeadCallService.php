<?php

namespace App\Services;

use App\Models\Call;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;

class LeadCallService
{
    public function __construct(
        private readonly LeadStatusService $leadStatusService,
    ) {
    }

    /**
     * @param array{duration:int,result:string,manager_id:int} $data
     */
    public function create(Lead $lead, array $data): Call
    {
        return DB::transaction(function () use ($lead, $data): Call {
            $call = $lead->calls()->create($data);

            $this->leadStatusService->applyAfterCall($lead->fresh(), $call);

            return $call->fresh();
        });
    }
}
