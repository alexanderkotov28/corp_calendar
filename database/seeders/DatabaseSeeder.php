<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Database\Factories\DepartmentFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Department::factory(20)
             ->has(User::factory()->count(20), 'users')
             ->create();

         User::factory()->create([
             'name' => 'admin',
             'email' => 'admin@admin.com',
             'password' => Hash::make('admin'),
             'is_admin' => true,
             'created_at' => Carbon::now(),
         ]);
    }
}
