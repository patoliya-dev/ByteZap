<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Attendance extends Model
{
    protected $fillable = ['user_id', 'date', 'status'];

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** ---- SCOPES ---- **/

    // Daily attendance
    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('date', Carbon::today());
    }

    // Weekly attendance (current week)
    public function scopeThisWeek(Builder $query): Builder
    {
        return $query->whereBetween('date', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ]);
    }
}
