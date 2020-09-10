<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Habilidades;
use App\Categorias;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            ['name'=>'SuperAdmin', 'email'=>'gustavdz@gmail.com', 'password'=>Hash::make('123123'), 'email_verified_at'=>date('Y-m-d H:i:s'), 'role'=>'admin'],
            ['name'=>'Empresa 1', 'email'=>'hola@deckasoft.com', 'password'=>Hash::make('123123'), 'email_verified_at'=>date('Y-m-d H:i:s'), 'role'=>'empresa'],
            ['name'=>'Aspirante 1', 'email'=>'gustavo@deckasoft.com', 'password'=>Hash::make('123123'), 'email_verified_at'=>date('Y-m-d H:i:s'), 'role'=>'aspirante']
        );
        foreach($users as $user){
            User::create($user);
        }

        $habilidades = [
            ['nombre'=>'Java'],
            ['nombre'=>'C#'],
            ['nombre'=>'Spring'],
            ['nombre'=>'Laravel'],
            ['nombre'=>'Excel'],
            ['nombre'=>'CRM'],
            ['nombre'=>'Ofimatica'],
            ['nombre'=>'Project'],
            ['nombre'=>'Base de datos']
        ];

        foreach($habilidades as $habilidad){
            Habilidades::create($habilidad);
        }

        $categorias = [
            ['nombre'=>'Comercial, ventas y Negocios'],
            ['nombre'=>'Administración'],
            ['nombre'=>'Sistemas'],
            ['nombre'=>'Desarrollador'],
            ['nombre'=>'Marketing y Publicidad'],
            ['nombre'=>'Tecnología']
        ];

        foreach($categorias as $categoria){
            Categorias::create($categoria);
        }

    }
}
