<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // insert a test admin if not exists
        $email = 'admin@example.test';

        $exists = DB::table('admin')->where('email', $email)->exists();
        if ($exists) {
            $this->command->info('Admin already exists: '.$email);
            return;
        }

        DB::table('admin')->insert([
            'id_admin' => (string) Str::uuid(),
            'username' => 'admin',
            'email' => $email,
            // default password: password
            'password' => Hash::make('password'),
            'created_date' => now(),
        ]);

        $this->command->info('Inserted admin: '.$email.' with password: password');
    }
}
