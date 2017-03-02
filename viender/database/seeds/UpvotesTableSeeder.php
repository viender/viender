<?php

use Illuminate\Database\Seeder;

class UpvotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Viender\Socialite\Models\Upvote::class, 1000)->create();
    }
}
