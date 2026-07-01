<?php

namespace App\Services;

use App\Models\Call;
use App\Models\Lead;

class LeadStatusService
{
    public function applyAfterCall(Lead $lead, Call $call): void
    {
        if ($lead->manager_id === null) {
            $lead->manager_id = $call->manager_id;
        }

        $newStatus = $this->resolveStatus($lead, $call);

        if ($newStatus !== null) {
            $lead->status = $newStatus;
        }

        if ($lead->isDirty(['manager_id', 'status'])) {
            $lead->save();
        }
    }

    private function resolveStatus(Lead $lead, Call $call): ?string
    {
        if ($call->result === Call::RESULT_SUCCESS) {
            return Lead::STATUS_WON;
        }

        if ($this->hasThreeNoAnswersInRow($lead)) {
            return Lead::STATUS_LOST;
        }

        if (
            $lead->status === Lead::STATUS_NEW
            && $lead->calls()->count() === 1
        ) {
            return Lead::STATUS_IN_PROGRESS;
        }

        return null;
    }

    private function hasThreeNoAnswersInRow(Lead $lead): bool
    {
        $results = $lead->calls()
            ->latest('created_at')
            ->latest('id')
            ->limit(3)
            ->pluck('result');

        return $results->count() === 3
            && $results->every(fn (string $result) => $result === Call::RESULT_NO_ANSWER);
    }
}
