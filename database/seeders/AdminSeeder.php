<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\Currency;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'malek',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ])->assignRole('admin');

        Currency::create([
            'iqd' => '1',
            'usd' => '1',
            'irr' => '1',
            'try' => '1',
        ]);

        Category::create([
            'name' => 'بابەتی زیاد کراو',
            'code' => '1',
            'type_delete' => '1',
        ]);
    }
}
