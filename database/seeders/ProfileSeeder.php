<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('profiles')->delete();

        \DB::table('profiles')->insert([
            [
                'id' => 1,
                'name' => 'Developer',
                'alias' => Str::slug('Developer'),
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'name' => 'Administrador',
                'alias' => Str::slug('Administrador'),
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
