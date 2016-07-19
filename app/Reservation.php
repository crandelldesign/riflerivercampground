<?php

namespace riflerivercampground;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    /**
     * Scope a query to only include active Reservations.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * Scope a query to only include inactive Reservations.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', 0);
    }
}
