<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=User::role('owner')->pluck('id');

       Board::factory(10)->make()->each(function(Board $board) use($user){
            $board->user_id=$user->random();

            $board->save();
        });
    }
}
