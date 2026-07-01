<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadCallRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'duration' => ['required', 'integer', 'min:0'],
            'result' => ['required', 'string', 'in:no_answer,callback_later,success'],
            'manager_id' => ['required', 'integer', 'exists:managers,id'],
        ];
    }
}
