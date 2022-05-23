<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationInformation extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = [
        'received_on',
    ];

    protected $guarded = [
        'amount', 'percent'
    ];
}
