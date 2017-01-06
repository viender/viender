<?php

use Illuminate\Database\Seeder;

class StarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Viender\Ideapool\Star::class, 1000)->create();
    }
}
