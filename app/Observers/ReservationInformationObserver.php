<?php

namespace App\Observers;

use App\Models\ReservationInformation;

class ReservationInformationObserver
{
    /**
     * Handle the ReservationInformation "saving" event.
     *
     * @param  \App\Models\ReservationInformation  $reservationInformation
     * @return void
     */
    public function saving(ReservationInformation $reservationInformation)
    {
        /*collect($reservationInformation->getGuarded())->each(function($value) use ($reservationInformation){
            unset($reservationInformation->$value);
        });*/
    }
}
