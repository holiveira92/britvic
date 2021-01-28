<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Veiculo;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VeiculosController extends Controller
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
        $veiculos = array();
        try{
          //Obtendo coleção de dados na base
          $veiculos = Veiculo::all();
        }catch(Throwable $e){
          report($e);
        }finally{
          //enviando dados para renderização da view contendo os dados do recurso via props vuejs
          return Inertia::render('Veiculo/Lista',[ 'veiculos' => $veiculos ]);
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
        $veiculos         = Veiculo::find($resource_id);
      }catch(Throwable $e){
        //reportando exceção recebida
        report($e);
      }finally{
        //enviando dados para renderização da view contendo os dados do recurso via props vuejs
        return Inertia::render('Veiculo/AtualizacaoForm',[ 'veiculos' => $veiculos ]);
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
      Validator::make($request->all(), [
            'modelo'    => ['required', 'string', 'max:255'],
            'marca'     => ['required', 'string', 'max:255'],
            'placa'     => ['required', 'string', Rule::unique('veiculos')->ignore($request->id)],
            'ano'       => ['required', 'integer'],
      ])->validateWithBag('updateProfileInformation');
      try{
        $veiculos = Veiculo::find($request->id);
        $veiculos->update([
            'modelo'    => $request->modelo,
            'marca'     => $request->marca,
            'placa'     => $request->placa,
            'ano'       => $request->ano,
        ]);
      }catch(Throwable $e){
        //reportando exceção recebida
        report($e);
      }finally{
        //redireciona para listagem
        return redirect()->route('veiculos');
      }
    }
    
    /**
     * Realiza a persistência do novo recurso na base de dados
     * @param Request $request - Dados do formulário
     * @return Redirect para view
     */
    public function insert(Request $request)
    {    
      //Realiza as validações necessárias para o recurso de acordo com sua regra
      Validator::make($request->all(), [
          'modelo'      => ['required', 'string', 'max:255'],
          'marca'       => ['required', 'string', 'max:255'],
          'placa'       => ['required', 'string', Rule::unique('veiculos')],
          'ano'         => ['required', 'integer'],
      ])->validate();
      Veiculo::create([
          'modelo'    => $request->modelo,
          'marca'     => $request->marca,
          'placa'     => $request->placa,
          'ano'       => $request->ano,
      ]);
      try{
      }catch(Throwable $e){
        //reportando exceção recebida
        report($e);
      }finally{
        //redireciona para listagem
        return redirect()->route('veiculos');
      }
    }
    
    /**
     * Inicializa componentes para recurso
     * Renderiza a view inicial de cadastro
     * @return View
     */
    public function create()
    {   
        return Inertia::render('Veiculo/CadastroForm',[]);
    }

    /**
     * Realiza a removação do recurso na base de dados
     * @param int $resource_id
     * @return Redirect para view
     */
    public function delete($resource_id)
    { 
      try{
        $veiculos = Veiculo::find($resource_id);
        $veiculos->delete();
      }catch(Throwable $e){
        //reportando exceção recebida
        report($e);
      }finally{
        //redireciona para listagem
        return redirect()->route('veiculos');
      }
    }

}
