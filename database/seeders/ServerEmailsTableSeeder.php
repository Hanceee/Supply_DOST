<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServerEmailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('server_emails')->insert([
            'email' => 'techsupport@region1.dost.gov.ph',
            'password' => ('T3chSupp012t'), // Assuming you want to hash the password
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
