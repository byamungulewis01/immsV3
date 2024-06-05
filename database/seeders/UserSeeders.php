<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $variable = [
            [
                'name' => 'BYAMUNGU Lewis',
                'email' => 'byamungulewis@gmail.com',
                'phone' => '0785436135',
                'status' => 'active',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'branch' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'NTWARI Lebon',
                'email' => 'ntwarilebon09@gmail.com',
                'phone' => '07221672722',
                'status' => 'active',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'branch' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ISHIMWE Gloria',
                'email' => 'gloria@gmail.com',
                'phone' => '0789818378',
                'status' => 'inactive',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'branch' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'NDIKUMANA Eric',
                'email' => 'ndikumanaeric001@gmail.com',
                'phone' => '0782185745',
                'status' => 'inactive',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'branch' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($variable as $data) {
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->phone = $data['phone'];
            $user->status = $data['status'];
            $user->password = $data['password'];
            $user->branch = $data['branch'];
            $user->created_at = $data['created_at'];
            $user->updated_at = $data['updated_at'];
            $user->save();
        }
    }
}
