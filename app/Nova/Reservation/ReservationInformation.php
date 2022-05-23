<?php

namespace App\Nova\Reservation;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class ReservationInformation extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ReservationInformation::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];



    /**
     * Get the fields displayed by the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Date::make('Received On')->default(now())->required(),
            Currency::make('Total Eur')->currency('EUR')->rules(['required']),
            Currency::make('Total Mad', 'total_sell')->currency('MAD')->dependsOn(
                ['total_eur'],
                function (Currency $field, NovaRequest $request, FormData $formData) {
                    $field->value = '';
                    if ($formData->total_eur != '') $field->value = $formData->total_eur * 10.5;
                }
            )->rules(['required']),
            Currency::make('Total Buy')->currency('MAD')->rules(['required']),
            Heading::make('Profit'),
            Currency::make('Amount')->currency('MAD')->dependsOn(
                ['total_sell', 'total_buy'],
                function (Currency $field, NovaRequest $request, FormData $formData) {
                    $field->value = '';
                    if ($formData->total_sell != '' && $formData->total_buy) $field->value = $formData->total_sell - $formData->total_buy;
                }
            )->readonly(),
            Text::make('Percent')->dependsOn(
                ['total_sell', 'total_buy'],
                function (Text $field, NovaRequest $request, FormData $formData) {
                    $field->value = '';
                    if ($formData->total_sell != '' && $formData->total_buy) $field->value = ((($formData->total_sell - $formData->total_buy) * 100) / $formData->total_sell) . '%';
                }
            )->readonly(),
        ];
    }
}
