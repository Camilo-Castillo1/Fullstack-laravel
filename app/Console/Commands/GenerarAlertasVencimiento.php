<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lote;
use App\Models\AlertaVencimiento;
use Carbon\Carbon;

class GenerarAlertasVencimiento extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'app:generar-alertas-vencimiento';

    /**
     * The console command description.
     */
    protected $description = 'Genera alertas de vencimiento para lotes cuyo tiempo de vida útil es de 10 días o menos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lotes = Lote::whereNotNull('fecha_ingreso')
                     ->whereNotNull('fecha_vencimiento')
                     ->get();

        $total = 0;

        foreach ($lotes as $lote) {
            $ingreso = Carbon::parse($lote->fecha_ingreso);
            $vencimiento = Carbon::parse($lote->fecha_vencimiento);
            $diasDiferencia = $ingreso->diffInDays($vencimiento, false);

            if ($diasDiferencia <= 10) {
                $yaExiste = AlertaVencimiento::where('lote_id', $lote->id)
                    ->where('fecha_vencimiento', $lote->fecha_vencimiento)
                    ->exists();

                if (! $yaExiste) {
                    AlertaVencimiento::create([
                        'lote_id' => $lote->id,
                        'fecha_vencimiento' => $lote->fecha_vencimiento,
                        'estado' => 'pendiente',
                    ]);
                    $total++;
                }
            }
        }

        $this->info("✅ Se generaron {$total} alerta(s) de vencimiento.");
    }
}
