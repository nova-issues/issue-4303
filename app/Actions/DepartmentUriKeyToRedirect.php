<?php

namespace App\Actions;

class DepartmentUriKeyToRedirect
{
    public static function get($morph_type): string
    {
        return match ($morph_type) {
            "App\Models\TourOperator" => "tour-operators",
            "App\Models\Hotel" => "hotels",
            "App\Models\Transporter" => "transporters",
            default => "tour-operators",
        };
    }
}
