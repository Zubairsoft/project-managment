<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $name=collect(['front-end','back-end','ui_ux','analysis']);
       $color=collect(Tag::COLOR);
       $card=Card::get()->pluck('id');
     User::role('owner')->get()->pluck('id')->each(function($user) use($name, $color,$card){
        Tag::factory(25)->make()->each(function($tag)use($name, $color,$card,$user){
            $tag->name=$name->random();
            $tag->color=$color->random();
            $tag->card_id=$card->random();
            $tag->creator_id=$user;
            $tag->save();
           });
     });
    }
}
