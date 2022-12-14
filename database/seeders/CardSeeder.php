<?php

namespace Database\Seeders;

use App\Models\BoardList;
use App\Models\Card;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = BoardList::get();
        Card::factory(50)->make()->each(function ($card) use ($list) {
            $card->list_id = $list->random()->id;
            $card->save();
        });
    }
}
