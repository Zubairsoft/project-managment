<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\BoardList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BoardListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lists=collect(['todo','in progress','test','done','hotfix']);
        
        Board::all()->each(function(Board $board)use($lists){
          $lists->each(function($list)use($board){
            $board->lists()->create([
                'name'=>$list
            ]);
          });
        });
     
    }
}
