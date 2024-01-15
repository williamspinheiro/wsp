<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProfilePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profiles = [
                    'Developer' => [
                        'permissions' => [
                            'grupo-de-acessos-menu',
                            'grupo-de-acessos-ativar',
                            'grupo-de-acessos-cadastrar',
                            'grupo-de-acessos-editar',
                            'grupo-de-acessos-excluir',
                            'usuarios-menu',
                            'usuarios-ativar',
                            'usuarios-cadastrar',
                            'usuarios-editar',
                            'usuarios-excluir',
                        ]
                    ],

                    'Administrador' => [
                        'permissions' => [
                            'grupo-de-acessos-menu',
                            'grupo-de-acessos-ativar',
                            'grupo-de-acessos-cadastrar',
                            'grupo-de-acessos-editar',
                            'grupo-de-acessos-excluir',
                            'usuarios-menu',
                            'usuarios-ativar',
                            'usuarios-cadastrar',
                            'usuarios-editar',
                            'usuarios-excluir',
                        ]
                    ]
                ];
        
        $this->insert($profiles);
    }

    private function insert(array $profiles)
    {
        \DB::table('profile_permissions')->delete();

        $profilePermissions = [];

        foreach ($profiles as $profileName => $permissions) {
            
            if (empty($permissions['permissions'])) {
                continue;
            }

            $profile = Profile::where('alias', Str::slug($profileName))->first();

            if (!empty($profile)) {

                foreach ($permissions['permissions'] as $permissionAlias) {

                    $permission = Permission::where('alias', $permissionAlias)->first();

                    $profilePermissions[] = [
                            'permission_id' => $permission->id,
                            'profile_id' => $profile->id,
                        ];
                }
            }
        }

        \DB::table('profile_permissions')->insert($profilePermissions);
    }
}
