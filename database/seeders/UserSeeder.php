<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Level;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $idAdmin = Level::where('level_name',
        'Super Admin')->first()->id;
        $idOperator = Level::where('level_name',
        'Operator')->first()->id;
        $idPimpinan = Level::where('level_name',
        'Pimpinan')->first()->id;

        User::updateOrCreate(
            ['email' => 'admin@laundry.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Admin123'),
                'id_level' => $idAdmin,
            ]
        );
        User::updateOrCreate(
            ['email' => 'operator@laundry.com'],
            [
                'name' => 'Operator',
                'password' => Hash::make('Operator123'),
                'id_level' => $idOperator,
            ]
        );
        User::updateOrCreate(
            ['email' => 'pimpinan@laundry.com'],
            [
                'name' => 'Pimpinan',
                'password' => Hash::make('Pimpinan123'),
                'id_level' => $idPimpinan,
            ]
        );
    }
}
