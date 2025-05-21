<?php

namespace App\Providers;
use App\Models\AlertaVencimiento;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
{
    view()->composer('*', function ($view) {
        $alertasUrgentes = AlertaVencimiento::with('lote.producto')
            ->where('estado', 'pendiente')
            ->orderBy('fecha_alerta_generada', 'desc')
            ->take(5)
            ->get();

        $view->with('alertasSidebar', $alertasUrgentes);
    });
}
}
