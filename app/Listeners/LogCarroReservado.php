<?php

namespace App\Listeners;

use App\Events\CarroReservado;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogCarroReservado
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CarroReservado  $event
     * @return void
     */
    public function handle(CarroReservado $event)
    {
        //registrando log ao reservar um veículo no sistema
        Log::info('Veículo ID: ' . $event->veiculo_id .' Reservado pelo usuário: ' . $event->user_id ,[
            'user_id'       => $event->user_id,
            'veiculo_id'    => $event->veiculo_id
        ]);
    }
}
