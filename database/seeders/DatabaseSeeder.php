<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Refactoring\AccountBalance;
use App\Models\Refactoring\Banner;
use App\Models\Refactoring\Invoice;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Invoice::factory()->count(10)->create();
        Banner::factory()->count(10)->create();
        AccountBalance::factory()->count(10)->create();
    }
}
