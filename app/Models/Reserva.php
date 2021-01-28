<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Support\Facades\DB;

class Reserva extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'veiculo_id',
        'data_inicio',
        'data_fim',
    ];

    public $timestamps = false;
    
    /**
     * Obtem lista personalizada mesclando reservas, veiculos e usuarios
     * @return array - lista de reservas
     */
    public static function getAll(){
        $reservas = DB::table('reservas')
            ->leftJoin('users', 'users.id', '=', 'reservas.user_id')
            ->leftJoin('veiculos', 'veiculos.id', '=', 'reservas.veiculo_id')
            ->select('reservas.*', 'veiculos.placa as placa', 'veiculos.modelo as modelo', 'veiculos.marca as marca',
            'users.name as nome', 'users.name as documento', 'users.name as email')
            ->get()->toArray();
        return $reservas;
    }
    
    /**
     * getReservasByDateUser
     *
     * @param  mixed $veiculo_id - Identidicação do veículo na base
     * @param  mixed $data_inicio 
     * @param  mixed $data_fim
     * @param  mixed optional $id - ID da reserva na base
     * @return array - lista de reservas por usuário e data
     */
    public static function getReservasByDateUser($veiculo_id, $data_inicio, $data_fim, $id=0){
        $reservas = DB::table('reservas')->select('*')
            ->where('id','!=',$id)
            ->where('veiculo_id', $veiculo_id)
            ->whereBetween('data_inicio', [$data_inicio, $data_fim])
            ->get()->toArray();
        return $reservas;
    }
    
    /**
     * Obtém lista de reservas para relatório de disponibilidade de veículos por mês
     * @param  mixed $veiculo_id
     * @param  mixed $data
     * @param  mixed $data_fim
     * @return array - lista de reservas e disponibilidade dos veículos
     */
    public static function getReservasReport($veiculo_id, $data, $data_fim){
        //realizando query raw
        $reservas = DB::select("SELECT * from reservas WHERE veiculo_id = $veiculo_id AND 
            (data_inicio BETWEEN '$data' AND '$data_fim') OR 
            (data_fim BETWEEN '$data' AND '$data_fim') OR 
            (data_inicio <= '$data' AND data_fim >= '$data_fim') ");
        $reservas = (!empty($reservas[0])) ? $reservas[0] : array();

        //realizando tratamento nas datas
        $disponibilidade = array(
            'dia' => strftime('%d ', strtotime($data)),
            'dia_semana' => strftime('%A', strtotime($data)),
            'mes' => strftime('%B', strtotime($data)),
            'disponivel' => (!empty($reservas->id)) ? "Nao" : "Sim",
        );
        return $disponibilidade;
    }

}
