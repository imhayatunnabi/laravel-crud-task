<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Alice Johnson',
                'email' => 'alice@example.com',
                'slug' => 'alice-johnson',
                'password' => bcrypt('password123')
            ],
            [
                'name' => 'Bob Smith',
                'email' => 'bob@example.com',
                'slug' => 'bob-smith',
                'password' => bcrypt('password123')
            ],
            [
                'name' => 'Carol Davis',
                'email' => 'carol@example.com',
                'slug' => 'carol-davis',
                'password' => bcrypt('password123')
            ],
            [
                'name' => 'David Wilson',
                'email' => 'david@example.com',
                'slug' => 'david-wilson',
                'password' => bcrypt('password123')
            ],
            [
                'name' => 'Eva Thomas',
                'email' => 'eva@example.com',
                'slug' => 'eva-thomas',
                'password' => bcrypt('password123')
            ],
        ];

        foreach ($users as $user) {
            $userId = DB::table('users')->insertGetId([
                'name' => $user['name'],
                'email' => $user['email'],
                'slug' => $user['slug'],
                'email_verified_at' => now(),
                'password' => $user['password'],
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            for ($i = 1; $i <= 4; $i++) {
                DB::table('blogs')->insert([
                    'title' => "Blog Post $i by " . $user['name'],
                    'slug' => Str::slug("Blog Post $i by " . $user['name']),
                    'description' => "This is a description for blog post $i by " . $user['name'],
                    'created_at' => now(),
                    'updated_at' => now(),
                    'created_by_id' => $userId,
                    'updated_by_id' => $userId,
                ]);
            }
        }
    }
}
