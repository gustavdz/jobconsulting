<?php

use Illuminate\Database\Seeder;
use App\Ofertas;

class OfertsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i<30000; $i++){
            Ofertas::create(['empresa_id'=>5,'titulo'=>'prueba '.$i,'descripcion'=>'descripcion '.$i,'salario'=>1000,'validez'=>date('Y-m-d H:i:s')]);
        }
    }
}
