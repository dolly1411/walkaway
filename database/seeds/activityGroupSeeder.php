<?php

use Illuminate\Database\Seeder;

class activityGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activity_groups')->insert([
            'activity_group' => 'CREATE_PLACE',
            'content' => 'you suggested a new place',
        ]);

        DB::table('activity_groups')->insert([
            'activity_group' => 'REGISTER',
            'content' => 'you have successfully registered with us',
        ]);

        DB::table('activity_groups')->insert([
            'activity_group' => 'LOGIN',
            'content' => 'Daily login',
        ]);
    }
}
