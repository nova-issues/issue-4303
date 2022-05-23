<?php

namespace App\Nova\Reservation;

use App\Nova\Parameters\TourOperator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Resource;

class Reservation extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Reservation::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'code';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'code', 'tour_operator_code'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make("Tour Operator", null, TourOperator::class)->withoutTrashed(),
            Text::make("Tour Operator Code")
                ->creationRules(['required', 'unique:reservations,tour_operator_code'])
                ->updateRules(['required', 'unique:reservations,tour_operator_code,{{resourceId}}']),
            HasOne::make('Reservation Information', null, ReservationInformation::class),
        ];
    }

    /**
     * Register a callback to be called after the resource is created.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public static function afterCreate(NovaRequest $request, Model $model)
    {
        $model->user_id = auth()->id();
        $model->code = sprintf('%06d', $model->id);
        $model->save();
    }
}
