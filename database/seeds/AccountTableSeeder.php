<?php

use Illuminate\Database\Seeder;
use App\Accounts;

class AccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Accounts::insert([
            'usn' => 'Administrator',
            'pwd' => Crypt::encryptString('temporary123'),
            'group' => 'Admin'
        ]);
    }
}
