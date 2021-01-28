<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsuariosController extends Controller
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
        $users = array();
        try{
          //Obtendo coleção de dados na base
          $users = User::all();
        }catch(Throwable $e){
          report($e);
        }finally{
          //enviando dados para renderização da view contendo os dados do recurso via props vuejs
          return Inertia::render('Usuarios',[ 'users' => $users ]);
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
        $user         = User::find($resource_id);
      }catch(Throwable $e){
        //reportando exceção recebida
        report($e);
      }finally{
        //enviando dados para renderização da view contendo os dados do recurso via props vuejs
        return Inertia::render('Profile/UpdateProfile',[ 'user' => $user ]);
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
        'name'      => ['required', 'string', 'max:255'],
        'email'     => ['required', 'email', 'max:255', Rule::unique('users')->ignore($request->id)],
        'document'  => ['required', 'string', 'max:255'],
      ])->validateWithBag('updateProfileInformation');
      try{
        $user = User::find($request->id);
        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'document'  => $request->document,
        ]);
      }catch(Throwable $e){
        //reportando exceção recebida
        report($e);
      }finally{
        //redireciona para listagem
        return redirect()->route('usuarios');
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
          'name'      => ['required', 'string', 'max:255'],
          'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
          'document'  => ['required', 'string', 'max:255'],
      ])->validate();
      try{
        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'document'  => $request->document,
            'password'  => Hash::make($request->password),
        ]);
      }catch(Throwable $e){
        //reportando exceção recebida
        report($e);
      }finally{
        //redireciona para listagem
        return redirect()->route('usuarios');
      }
    }
    
    /**
     * Inicializa componentes para recurso
     * Renderiza a view inicial de cadastro
     * @return View
     */
    public function create()
    {   
        return Inertia::render('Auth/RegisterNew',[]);
    }

    /**
     * Realiza a removação do recurso na base de dados
     * @param int $resource_id
     * @return Redirect para view
     */
    public function delete($resource_id)
    { 
      try{
        $user = User::find($resource_id);
        $user->delete();
      }catch(Throwable $e){
        //reportando exceção recebida
        report($e);
      }finally{
        //redireciona para listagem
        return redirect()->route('usuarios');
      }
    }

}
