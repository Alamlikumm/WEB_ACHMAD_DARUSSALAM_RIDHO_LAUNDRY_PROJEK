<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Level::firstOrCreate(['level_name' => 
        'Super Admin']);
        Level::firstOrCreate(['level_name' =>
        'Operator']);
        Level::firstOrCreate(['level_name' =>
        'Pimpinan']);
    }
}
