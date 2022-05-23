<?php

namespace App\Providers;

use App\Nova\Parameters\Circuit;
use App\Nova\Parameters\Extra;
use App\Nova\Parameters\Hotel;
use App\Nova\Parameters\Restaurant;
use App\Nova\Parameters\TourOperator;
use App\Nova\Parameters\TransportCategory;
use App\Nova\Parameters\Transporter;
use App\Nova\Parameters\TransportService;
use App\Nova\Reservation\Reservation;
use App\Nova\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Dashboards\Main;
use Laravel\Nova\Menu\MenuGroup;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::dashboard(Main::class)->icon('chart-bar'),

                MenuSection::make('Parameters', [
                    MenuItem::link('Activity Log', '/resources/action-events')->canSee(function(Request $request) {
                        return $request->user()->role == 'admin';
                    }),
                    MenuItem::resource(User::class),
                    MenuItem::resource(TourOperator::class),
                    MenuItem::resource(Hotel::class),
                    MenuGroup::make('Transport', [
                        MenuItem::resource(Transporter::class),
                        MenuItem::resource(TransportService::class)->name('Services'),
                        MenuItem::resource(TransportCategory::class)->name('Categories'),
                    ])->collapsable(),
                    MenuItem::resource(Restaurant::class),
                    MenuItem::resource(Circuit::class),
                    MenuItem::resource(Extra::class),
                ])->icon('cog')->collapsable(),
                MenuSection::make('Reservations', [
                    MenuItem::resource(Reservation::class),
                ])->icon('cog')->collapsable(),
            ];
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
