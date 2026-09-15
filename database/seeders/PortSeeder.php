<?php

namespace Database\Seeders;

use App\Models\Port;
use Illuminate\Database\Seeder;

class PortSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['name' => 'Sanur', 'area' => 'Bali'],
            ['name' => 'Kusamba', 'area' => 'Bali'],
            ['name' => 'Padang Bai', 'area' => 'Bali'],
            ['name' => 'Nusa Penida', 'area' => 'Nusa Penida'],
            ['name' => 'Nusa Lembongan', 'area' => 'Nusa Lembongan'],
            ['name' => 'Gili Trawangan', 'area' => 'Gili'],
            ['name' => 'Gili Air', 'area' => 'Gili'],
            ['name' => 'Bangsal', 'area' => 'Lombok'],
        ] as $port) {
            Port::query()->firstOrCreate(['name' => $port['name']], $port);
        }
    }
}
