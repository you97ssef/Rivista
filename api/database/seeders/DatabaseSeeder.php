<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\Models\User();
        
        $user->first_name = 'Youssef';
        $user->last_name = 'BAHI';
        $user->slug = 'youssef';
        $user->role = \App\Enums\UserRole::ADMIN;
        $user->email = 'you97ssef@gmail.com';
        $user->email_verified_at = now();
        $user->password = '$2y$10$1HPnO9uiUSEQv2va9KmH.OUJ8p./O2hU6thIPKCkNost962BZM5g6'; 
        $user->remember_token = Str::random(10);
        
        $user->save();

        // \App\Models\User::factory(100)->create();
        // \App\Models\Category::factory(10)->create();
        // \App\Models\Rivista::factory(1000)->create();
        // \App\Models\Comment::factory(5000)->create();
        // \App\Models\Like::factory(10000)->create();
        // \App\Models\Media::factory(500)->create();
    }
}
