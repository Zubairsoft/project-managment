<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Card::all()->each(function(Card $card){
            $users=User::role('employee')->inRandomOrder()->take(2)->get()->pluck('id');
            $card->assignedUsers()->sync($users);
        });
    }
}
