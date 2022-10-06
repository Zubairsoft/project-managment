<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owner=User::factory(3)->create();
        $owner->each(function(User $user){
            $user->assignRole('owner');
        });
         Company::factory(3)->make()->each(function($company) use($owner){
         $company->owner_id=$owner->random()->id;
         $company->save();
         
        });
       
    }
}
