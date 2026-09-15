<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => config('penida.admin.email')],
            [
                'name' => config('penida.admin.name'),
                'password' => config('penida.admin.password'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ],
        );
    }
}
