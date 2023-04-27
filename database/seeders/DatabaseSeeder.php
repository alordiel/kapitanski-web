<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin Spasov',
            'email' => 'spasov@timelinedev.com',
            'password' => Hash::make('123!@#123'),
        ]);
        DB::table('users')->insert([
            'name' => 'Student Spasov',
            'email' => 'student@timelinedev.com',
            'password' => Hash::make('123!@#123'),
        ]);
        DB::table('users')->insert([
            'name' => 'Teacher Spasov',
            'email' => 'teacher@timelinedev.com',
            'password' => Hash::make('123!@#123'),
        ]);

        $this->call([
            RoleAndPermissionSeeder::class,
        ]);
    }
}
