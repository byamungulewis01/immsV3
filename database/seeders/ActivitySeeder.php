<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            ['name' => 'Customer Management'],
            ['name' => 'Branch Management'],
            ['name' => 'Role $ Permisson Management'],
            ['name' => 'Setting Management'],
            ['name' => 'Employees Management'],
        ];
        \App\Models\Activity::insert($data);
    }
}
