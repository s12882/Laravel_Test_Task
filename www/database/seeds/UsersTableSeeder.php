<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
      User::create([
          'login' => 'root',
          'email' => 'whooles96@gmail.com',
          'password' => \Hash::make('toor'),
          'first_name' => 'Andrii',
          'surname' => 'Slobodian',
          'phoneNumber' => '555555555'
        ]);
		
		User::create([
          'login' => 'guest',
          'email' => 's12882@pjwstk.edu.pl',
          'password' => \Hash::make('1234'),
          'first_name' => 'Guest',
          'surname' => 'Account ',
          'phoneNumber' => '099366877'
        ]);

        $users = factory(App\Models\User::class, 6)->create();
      }
}
