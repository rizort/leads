<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'phone', 'status', 'manager_id'])]
class Lead extends Model
{
    use HasFactory;

    public const STATUS_NEW = 'new';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_WON = 'won';
    public const STATUS_LOST = 'lost';

    public $timestamps = false;

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }

    public function calls(): HasMany
    {
        return $this->hasMany(Call::class);
    }
}
