<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Branch::create([
            'name' => 'KIGALI',
            'status' => 'active',
        ]);
        Branch::create([
            'name' => 'MUSANZE',
            'status' => 'inactive',
        ]);
        Branch::create([
            'name' => 'RUBAVU',
            'status' => 'active',
        ]);
        Branch::create([
            'name' => 'KARONGI',
            'status' => 'inactive',
        ]);
        Branch::create([
            'name' => 'HUYE',
            'status' => 'active',
        ]);
    }
}
