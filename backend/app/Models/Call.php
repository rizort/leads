<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['lead_id', 'duration', 'result', 'manager_id', 'created_at'])]
class Call extends Model
{
    use HasFactory;

    public const RESULT_NO_ANSWER = 'no_answer';
    public const RESULT_CALLBACK_LATER = 'callback_later';
    public const RESULT_SUCCESS = 'success';

    public const UPDATED_AT = null;

    public $timestamps = true;
}
