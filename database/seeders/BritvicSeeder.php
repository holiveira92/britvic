<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Veiculo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

class BritivicSeeder extends Seeder
{
    public function run()
    {   
        // Apaga toda a tabela de usuários
        DB::table('users')->truncate();

        //Cria usuários admins
        $this->createAdmins();

        //Cria usuários
        $this->createUsers();

        //Cria Veículos
        $this->createVeiculos();
    }

    private function createAdmins()
    {
        User::create([
            'email'     => 'admin@admin.com', 
            'name'      => 'Administrador',
            'document'  => "734.487.991-30",
            'password'  => Hash::make('12345678')
        ]);
        
        User::create([
            'email'     => 'teste@teste.com', 
            'name'      => 'Teste',
            'document'  => "263.347.788-70",
            'password'  => Hash::make('12345678')
        ]);
    }
    
    private function createUsers()
    {
        $max = rand(10, 30);
        for($i=0; $i < $max; $i++):
            $this->createUser($i);
        endfor;

    }

    private function createUser($index)
    {   
        return User::create([
            'email'     => 'email' . $index . '@mail.com', 
            'name'      => 'User ' . $index,
            'document'  => 'TXTTST' . $index,
            'password'  => Hash::make('12345678')
        ]);
    }

    private function createVeiculos(){
        $max = 10;
        $marcas = array('Chevrolet', 'Hyundai', 'Ferrari', 'Fiat', 'Ford');
        for($i=0; $i < $max; $i++):
            Veiculo::create([
                'modelo'    => "XYZT PREMIER",
                'marca'     => array_rand($marcas, 1),
                'placa'     => "ABC$i2$i5",
                'ano'       => 2021,
            ]);
        endfor;
    }
}