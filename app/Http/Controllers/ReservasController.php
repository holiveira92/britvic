<?php

namespace App\Http\Controllers;

use Throwable;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Reserva;
use App\Models\Veiculo;
use App\Rules\Reservado;
use Illuminate\Http\Request;
use App\Events\CarroReservado;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ReservasController extends Controller
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
        $reservas = array();
        try{
          //Obtendo coleção de dados na base
          $reservas = Reserva::getAll();
        }catch(Throwable $e){
          report($e);
        }finally{
          //enviando dados para renderização da view contendo os dados do recurso via props vuejs
          return Inertia::render('Reserva/Lista',[ 'reservas'  => $reservas ]);
        }
    }
    
    /**
     * Obtem dados recurso cadastrado no sistema para GET na base e exibição do estado atual
     * @param int $resource_id - ID do recurso
     * @return Redirect para view
     */
    public function edit($resource_id)
    {  
      try{
        //Obtendo dados do recurso na base
        $reservas         = Reserva::find($resource_id);
        $users            = User::all();
        $veiculos         = Veiculo::all();
      }catch(Throwable $e){
        //reportando exceção recebida
        report($e);
      }finally{
        //enviando dados para renderização da view contendo os dados do recurso via props vuejs
        return Inertia::render('Reserva/AtualizacaoForm',[ 
          'reservas'  => $reservas ,
          'users'     => $users ,
          'veiculos'  => $veiculos ,
        ]);
      }
    }
    
    /**
     * Realiza a persistência do recurso atualizado na base de dados
     * @param Request $request - Dados do formulário
     * @return Redirect para view
     */
    public function update(Request $request)
    {  
      //Realiza as validações necessárias para o recurso de acordo com sua regra
      $request->validate([$request->all(),
        'data_inicio' => ['required', new Reservado($request)],
      ]);
      $reservas = Reserva::find($request->id);
      $reservas->update([
        'user_id'         => intval($request->user_id),
        'veiculo_id'      => intval($request->veiculo_id),
        'data_inicio'     => $request->data_inicio,
        'data_fim'        => $request->data_fim,
      ]);
      try{
      }catch(Throwable $e){
        //reportando exceção recebida
        report($e);
      }finally{
        //redireciona para listagem
        return redirect()->route('reservas');
      }
    }
    
    /**
     * Realiza a persistência do novo recurso na base de dados
     * @param Request $request - Dados do formulário
     * @return Redirect para view
     */
    public function insert(Request $request)
    {    
      try{
        //Realiza as validações necessárias para o recurso de acordo com sua regra
        $request->validate([$request->all(),
          'data_inicio' => ['required', new Reservado($request)],
        ]);
        Reserva::create([
            'user_id'         => intval($request->user_id),
            'veiculo_id'      => intval($request->veiculo_id),
            'data_inicio'     => $request->data_inicio,
            'data_fim'        => $request->data_fim,
        ]);
      }catch(Throwable $e){
        //reportando exceção recebida
        report($e);
      }finally{
        //Disparando evento no sistema
        event(new CarroReservado($request->user_id,$request->veiculo_id));

        //redireciona para listagem
        return redirect()->route('reservas');
      }
    }
    
    /**
     * Inicializa componentes para recurso
     * Renderiza a view inicial de cadastro
     * @return View
     */
    public function create()
    {   
        $reservas       = Reserva::getAll();
        $users          = User::all();
        $veiculos       = Veiculo::all();
        return Inertia::render('Reserva/CadastroForm',[
            'reservas'  => $reservas ,
            'users'     => $users ,
            'veiculos'  => $veiculos ,
        ]);
    }

    /**
     * Realiza a removação do recurso na base de dados
     * @param int $resource_id
     * @return Redirect para view
     */
    public function delete($resource_id)
    { 
      try{
        $reservas = Reserva::find($resource_id);
        $reservas->delete();
      }catch(Throwable $e){
        //reportando exceção recebida
        report($e);
      }finally{
        //redireciona para listagem
        return redirect()->route('reservas');
      }
    }

}
