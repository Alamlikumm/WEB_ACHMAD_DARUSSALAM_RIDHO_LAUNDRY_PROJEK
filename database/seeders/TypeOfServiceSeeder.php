<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeOfService;

class TypeOfServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeOfService::create([
            'service_name' => 'Cuci dan Gosok',
            'price' => 5000,
            'description' => 'Layanan Cuci dan Setrika per KG',
            'unit' => 'kg',
        ]);

        TypeOfService::create([
            'service_name' => 'Hanya Cuci',
            'price' => 4500,
            'description' => 'Layanan Cuci saja per KG',
            'unit' => 'kg',
        ]);

        TypeOfService::create([
            'service_name' => 'Hanya Gosok',
            'price' => 5000,
            'description' => 'Layanan Setrika Saja per KG',
            'unit' => 'kg',
        ]);

        TypeOfService::create([
            'service_name' => 'Laundry Besar',
            'price' => 7000,
            'description' => 'Selimut, Karpet, Mantel, Sprei per KG',
            'unit' => 'kg',
        ]);
    }
}
