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
            Ofertas::create(['empresa_id'=>2,'titulo'=>'oferta '.$i,'descripcion'=>'descripcion '.$i,'salario'=>rand(800,2800),'validez'=>date('Y-m-d H:i:s')]);
        }
    }
}
