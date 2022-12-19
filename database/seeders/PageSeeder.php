<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->insert([
            [
                'title' => 'WELCOME',
                'slug' => 'welcome',
                'image' => null,
                'content' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'INDEX BOTTOM',
                'slug' => 'index-bottom',
                'image' => null,
                'content' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'ABOUT US PAGE',
                'slug' => 'about-us-page',
                'image' => null,
                'content' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'CLASS SIDE BAR',
                'slug' => 'class-side-bar',
                'image' => null,
                'content' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'VISION&MISSION',
                'slug' => 'vision&mission',
                'image' => null,
                'content' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'CONTACT US',
                'slug' => 'contact-us',
                'image' => null,
                'content' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
