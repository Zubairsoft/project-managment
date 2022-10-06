<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            CompanySeeder::class,
            UserSeeder::class,
            BoardSeeder::class,
            BoardListSeeder::class,
            CardSeeder::class,
            MemberSeeder::class,
            CommentSeeder::class,
            TagSeeder::class

            


        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
