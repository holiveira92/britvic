<?php

namespace App\Http\Controllers;

use DateTime;
use Throwable;
use DatePeriod;
use DateInterval;
use Inertia\Inertia;
use App\Models\Reserva;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class DisponibilidadeController extends Controller
{       
    /**
     * Construtor da classe já realizando as validações de autenticação do usuário logado utilizando midd do laravel
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Função inicial de get do endpoint
     * Realiza a busca dos itens para listagem
     * @return View
     */
    public function index()
    {   
      try{
          //Obtendo coleção de dados na base
          $veiculos         = Veiculo::all();
          $reservas         = Reserva::getAll();
          $disponibilidade  = array();
          $selecao          = array('veiculo_id' => 0, 'mes' => date("m"));
        }catch(Throwable $e){
          report($e);
        }finally{
          //enviando dados para renderização da view contendo os dados do recurso via props vuejs
          return Inertia::render('Disponibilidade/Lista',[ 
            'disponibilidade'   => $disponibilidade ,
            'veiculos'          => $veiculos ,
            'selecao'           => $selecao ,
          ]);
        }
    }

    /**
     * Função inicial de get do endpoint
     * Realiza a busca dos itens para listagem
     * @return View
     */
    public function filter($veiculo_id,$mes)
    {   
      try{
          //Obtendo coleção de dados na base
          $disponibilidade    = array();
          $veiculos           = Veiculo::all();
          $reservas           = Reserva::getAll();
          $selecao            = array('veiculo_id' => $veiculo_id, 'mes' => $mes);
          $disponibilidade    = $this->getPeriodos($veiculo_id,$mes);
        }catch(Throwable $e){
          report($e);
        }finally{
          //enviando dados para renderização da view contendo os dados do recurso via props vuejs
          return Inertia::render('Disponibilidade/Lista',[ 
            'disponibilidade'   => $disponibilidade ,
            'veiculos'          => $veiculos ,
            'selecao'           => $selecao ,
          ]);
        }
    }
    
    /**
     * Obtém e organiza a lista de dados de veículos disponibilizados por dia
     * @param  mixed $veiculo_id - Veículo selecionado para o filtro
     * @param  mixed $mes - Mês selecionado para o filtro
     * @return array $disponibilidade - Lista de disponibilidade do veiculo por dia no mes
     */
    private function getPeriodos($veiculo_id,$mes){
        $disponibilidade    = array();
        $default            = array("id" => 0, "user_id" => 0, "veiculo_id" => 0, "data_inicio" => "", "data_fim" => "");
        $date               = new DateTime();
        $startDate          = DateTime::createFromFormat("Y-m-d", $date->format("Y-$mes-01"));

        //realiza traamento para mês fevereiro
        if($mes == "02"){
          $endDate          = DateTime::createFromFormat("Y-m-d", $date->format("Y-$mes-28"));
        }else{
          $endDate          = DateTime::createFromFormat("Y-m-d", $date->format("Y-$mes-t"));
          $endDate          = $endDate->modify('+1 day'); 
        }
        $periodo            = new DatePeriod($startDate,new DateInterval('P1D'),$endDate);

        //itera sob o range de datas para realizar a busca na base de dados
        foreach ($periodo as $key => $value) {
          $data             = $value->format('Y-m-d');
          $disponibilidade_dia = Reserva::getReservasReport($veiculo_id,$data,$endDate->format("Y-m-d"));
          $disponibilidade[]= !empty($disponibilidade_dia) ? $disponibilidade_dia : $default;
        }
        //dd($disponibilidade);
        return $disponibilidade;
    }
    

}
