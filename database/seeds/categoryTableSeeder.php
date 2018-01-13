<?php

use Illuminate\Database\Seeder;

class categoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('categories')->insert([
            'name' => "Historical",
            'alias' => "historical",
            'status' => 1
        ]);

         DB::table('categories')->insert([
            'name' => "Monuments",
            'alias' => "monuments",
            'status' => 1
        ]);

         DB::table('categories')->insert([
            'name' => "Cultural",
            'alias' => "cultural",
            'status' => 1
        ]);

         DB::table('categories')->insert([
            'name' => "Landmarks",
            'alias' => "landmarks",
            'status' => 1
        ]);

        DB::table('categories')->insert([
            'name' => "Locale",
            'alias' => "locale",
            'status' => 1
        ]);
    }
}
