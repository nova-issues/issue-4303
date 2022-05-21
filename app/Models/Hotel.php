<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    use HasFactory, SoftDeletes;

    public function departments() {
        return $this->morphMany(Department::class, 'departmentable');
    }

    public function roomTypes() {
        return $this->hasMany(RoomType::class);
    }
}
