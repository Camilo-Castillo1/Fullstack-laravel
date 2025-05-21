<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\GenerarAlertasVencimiento;

class Kernel extends ConsoleKernel
{
    /**
     * Registrar comandos personalizados.
     */
    protected $commands = [
        GenerarAlertasVencimiento::class,
        \App\Console\Commands\GenerarAlertasVencimiento::class,
    ];

    /**
     * Definir tareas programadas.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Ejecutar el comando todos los días a las 8:00 AM
        $schedule->command('app:generar-alertas-vencimiento')->dailyAt('08:00');
    }

    /**
     * Cargar comandos adicionales.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
