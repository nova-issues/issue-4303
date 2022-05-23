<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    public function tourOperator() {
        return $this->belongsTo(TourOperator::class);
    }

    public function reservationInformation() {
        return $this->hasOne(ReservationInformation::class);
    }
}
