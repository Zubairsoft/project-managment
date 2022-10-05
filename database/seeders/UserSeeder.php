<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company=Company::get();
        User::factory(15)->make()->each(function($user)use($company){
            $user->company_id=$company->random()->id;
            $user->assignRole("employee");
            $user->save();
        });
    }
}
