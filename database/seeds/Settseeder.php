<?php

use Illuminate\Database\Seeder;
use App\Settings;

class Settseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::insert([
            'globalSale' => '0',
            'tax' => '0',
            'car1' => 'carousel1.png',
            'car2' => 'carousel2.png',
            'car3' => 'carousel3.png'
        ]);
    }
}
