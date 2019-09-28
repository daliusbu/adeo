<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory('App\User', 3)->create();
        DB::table('users')
            ->updateOrInsert(
                [
                    'email' => 'admin',
                ],
                [
                    'name' => 'Root Administrator',
                    'email' => 'admin',
                    'password' => Hash::make('admin'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

        factory('App\Product', 20)->create();
        factory('App\Review', 100)->create();
    }
}
