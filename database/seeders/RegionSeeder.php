<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('regions')->delete();

        \DB::table('regions')->insert(array (
                0 => 
                array (
                        'id' => '1',
                        'country_id' => 32,
                        'name' => 'Acre',
                        'alias' => Str::slug('Acre'),
                        'uf' => 'AC',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                1 => 
                array (
                        'id' => '2',
                        'country_id' => 32,
                        'name' => 'Alagoas',
                        'alias' => Str::slug('Alagoas'),
                        'uf' => 'AL',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                2 => 
                array (
                        'id' => '3',
                        'country_id' => 32,
                        'name' => 'Amazonas',
                        'alias' => Str::slug('Amazonas'),
                        'uf' => 'AM',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                3 => 
                array (
                        'id' => '4',
                        'country_id' => 32,
                        'name' => 'Amapá',
                        'alias' => Str::slug('Amapá'),
                        'uf' => 'AP',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                4 => 
                array (
                        'id' => '5',
                        'country_id' => 32,
                        'name' => 'Bahia',
                        'alias' => Str::slug('Bahia'),
                        'uf' => 'BA',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                5 => 
                array (
                        'id' => '6',
                        'country_id' => 32,
                        'name' => 'Ceará',
                        'alias' => Str::slug('Ceará'),
                        'uf' => 'CE',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                6 => 
                array (
                        'id' => '7',
                        'country_id' => 32,
                        'name' => 'Distrito Federal',
                        'alias' => Str::slug('Distrito Federal'),
                        'uf' => 'DF',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                7 => 
                array (
                        'id' => '8',
                        'country_id' => 32,
                        'name' => 'Espírito Santo',
                        'alias' => Str::slug('Espírito Santo'),
                        'uf' => 'ES',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                8 => 
                array (
                        'id' => '9',
                        'country_id' => 32,
                        'name' => 'Goiás',
                        'alias' => Str::slug('Goiás'),
                        'uf' => 'GO',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                9 => 
                array (
                        'id' => '10',
                        'country_id' => 32,
                        'name' => 'Maranhão',
                        'alias' => Str::slug('Maranhão'),
                        'uf' => 'MA',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                10 => 
                array (
                        'id' => '11',
                        'country_id' => 32,
                        'name' => 'Minas Gerais',
                        'alias' => Str::slug('Minas Gerais'),
                        'uf' => 'MG',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                11 => 
                array (
                        'id' => '12',
                        'country_id' => 32,
                        'name' => 'Mato Grosso do Sul',
                        'alias' => Str::slug('Mato Grosso do Sul'),
                        'uf' => 'MS',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                12 => 
                array (
                        'id' => '13',
                        'country_id' => 32,
                        'name' => 'Mato Grosso',
                        'alias' => Str::slug('Mato Grosso'),
                        'uf' => 'MT',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                13 => 
                array (
                        'id' => '14',
                        'country_id' => 32,
                        'name' => 'Pará',
                        'alias' => Str::slug('Pará'),
                        'uf' => 'PA',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                14 => 
                array (
                        'id' => '15',
                        'country_id' => 32,
                        'name' => 'Paraíba',
                        'alias' => Str::slug('Paraíba'),
                        'uf' => 'PB',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                15 => 
                array (
                        'id' => '16',
                        'country_id' => 32,
                        'name' => 'Pernambuco',
                        'alias' => Str::slug('Pernambuco'),
                        'uf' => 'PE',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                16 => 
                array (
                        'id' => '17',
                        'country_id' => 32,
                        'name' => 'Piauí',
                        'alias' => Str::slug('Piauí'),
                        'uf' => 'PI',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                17 => 
                array (
                        'id' => '18',
                        'country_id' => 32,
                        'name' => 'Paraná',
                        'alias' => Str::slug('Paraná'),
                        'uf' => 'PR',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                18 => 
                array (
                        'id' => '19',
                        'country_id' => 32,
                        'name' => 'Rio de Janeiro',
                        'alias' => Str::slug('Rio de Janeiro'),
                        'uf' => 'RJ',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                19 => 
                array (
                        'id' => '20',
                        'country_id' => 32,
                        'name' => 'Rio Grande do Norte',
                        'alias' => Str::slug('Rio Grande do Norte'),
                        'uf' => 'RN',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                20 => 
                array (
                        'id' => '21',
                        'country_id' => 32,
                        'name' => 'Rondônia',
                        'alias' => Str::slug('Rondônia'),
                        'uf' => 'RO',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                21 => 
                array (
                        'id' => '22',
                        'country_id' => 32,
                        'name' => 'Roraima',
                        'alias' => Str::slug('Roraima'),
                        'uf' => 'RR',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                22 => 
                array (
                        'id' => '23',
                        'country_id' => 32,
                        'name' => 'Rio Grande do Sul',
                        'alias' => Str::slug('Rio Grande do Sul'),
                        'uf' => 'RS',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                23 => 
                array (
                        'id' => '24',
                        'country_id' => 32,
                        'name' => 'Santa Catarina',
                        'alias' => Str::slug('Santa Catarina'),
                        'uf' => 'SC',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                24 => 
                array (
                        'id' => '25',
                        'country_id' => 32,
                        'name' => 'Sergipe',
                        'alias' => Str::slug('Sergipe'),
                        'uf' => 'SE',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                25 => 
                array (
                        'id' => '26',
                        'country_id' => 32,
                        'name' => 'São Paulo',
                        'alias' => Str::slug('São Paulo'),
                        'uf' => 'SP',
                        'created_at' => date('Y-m-d H:i:s'),
                ),
                26 => 
                array (
                        'id' => '27',
                        'country_id' => 32,
                        'name' => 'Tocantins',
                        'alias' => Str::slug('Tocantins'),
                        'uf' => 'TO',
                        'created_at' => date('Y-m-d H:i:s'),
                )
        ));
    }
}
