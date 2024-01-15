<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [];
        $id = 1;
        $permissionIds = [];
        $modules = [
            [
                'name' => 'Grupo de Acessos',
                'permissions' => [
                    ["name" => 'Menu', 'description' => 'Exibe o menu de Grupo de Acessos.'], 
                    ["name" => 'Ativar', 'description' => ''],
                    ["name" => 'Cadastrar', 'description' => ''],
                    ["name" => 'Editar', 'description' => ''], 
                    ["name" => 'Excluir', 'description' => ''],
                ]
            ],

            [
                'name' => 'Usuários',
                'permissions' => [ 
                    ["name" => 'Menu', 'description' => 'Exibe o menu de Usuários.'],
                    ["name" => 'Ativar', 'description' => ''],
                    ["name" => 'Cadastrar', 'description' => ''],
                    ["name" => 'Editar', 'description' => ''], 
                    ["name" => 'Excluir', 'description' => ''],
                ]
            ]
        ];

        foreach ($modules as $module) {

            foreach ($module['permissions'] as $permission) {

                $items[] = [
                                'name' => $module['name']. ' - ' . $permission['name'],
                                'alias' => Str::slug($module['name']. ' - ' . $permission['name']),
                                'description' => $permission['description'],
                                'created_at' => date('Y-m-d H:i:s'),
                            ];
                
                $permissionIds[] = $id;
                $id++;
            }
        }

        \DB::table('permissions')->delete();

        \DB::table('permissions')->insert($items);
    }
}
