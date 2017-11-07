<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $user = factory(App\User::class)->create([
             'username' => 'dacastro',
             'email' => 'dacastro@uao.edu.co',
             'password' => bcrypt('root'),
             'lastname' => 'Castro',
             'firstname' => 'David'
         ]);
    }
}
