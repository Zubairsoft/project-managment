<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $card=Card::get();
        $user=User::get();

        Comment::factory(60)->make()->each(function($comment)use($card,$user){
$comment->card_id=$card->random()->id;
$comment->user_id=$user->random()->id;
$comment->save();
        });
    }
}
