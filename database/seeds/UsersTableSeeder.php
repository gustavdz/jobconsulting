<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Habilidades;
use App\Categorias;
use App\Ofertas;
use App\CategoriasOfertas;
use App\HabilidadesOfertas;
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

        $ofertas = [
            ['empresa_id'=>2,'titulo'=>'prueba uno','descripcion'=>'descripcion','salario'=>1000,'validez'=>date('Y-m-d H:i:s')],
            ['empresa_id'=>2,'titulo'=>'prueba dos','descripcion'=>'descripcion','salario'=>1000,'validez'=>date('Y-m-d H:i:s')]
        ];

        foreach($ofertas as $oferta){
            Ofertas::create($oferta);
        }

        $habilidades_ofertas = [
            ['habilidad_id'=>1,'oferta_id'=>1],
            ['habilidad_id'=>2,'oferta_id'=>1],
            ['habilidad_id'=>3,'oferta_id'=>1],
            ['habilidad_id'=>4,'oferta_id'=>1],
            ['habilidad_id'=>1,'oferta_id'=>2],
            ['habilidad_id'=>5,'oferta_id'=>2],
            ['habilidad_id'=>6,'oferta_id'=>2],
            ['habilidad_id'=>9,'oferta_id'=>2],
        ];

        foreach($habilidades_ofertas as $ho){
            HabilidadesOfertas::create($ho);
        }

        $categorias_ofertas = [
            ['categoria_id'=>1,'oferta_id'=>1],
            ['categoria_id'=>2,'oferta_id'=>1],
            ['categoria_id'=>4,'oferta_id'=>1],
            ['categoria_id'=>1,'oferta_id'=>2],
            ['categoria_id'=>6,'oferta_id'=>2],
        ];

        foreach($categorias_ofertas as $co){
            CategoriasOfertas::create($co);
        }

    }
}
