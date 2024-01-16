<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userInserts = [];
        $users = [
            [
                "name" => "System",
                "email" => "system@wsp.com.br",
                "profile_id" => 1,
            ],

            [ 
                "name" => "William Pinheiro",
                "email" => "william.pinheiro@outlook.com",
                "profile_id" => 1,
            ],
        ];
        
        foreach ($users as $user) {

            $userExists = User::where('email', $user['email'])->first();

            if (empty($userExists)) {
                $userInserts[] = [
                                    "name" => $user['name'],
                                    "alias" => Str::slug($user['name']),
                                    "email" => $user['email'],
                                    "profile_id" => $user['profile_id'],
                                    "password" => (!isset($user['password'])) ? bcrypt('System@2024') : bcrypt($user['password']),
                                ];
            }
        }

        \DB::table('users')->insert($userInserts);
    }
}
