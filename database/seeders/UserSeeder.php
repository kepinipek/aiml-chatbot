<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' =>  Hash::make('password'),
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'is_admin' => true
            ],
            [
                'name' => 'Non Admin',
                'email' => 'nonadmin@gmail.com',
                'password' =>  Hash::make('password'),
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'is_admin' => false
            ]
        ];

        foreach ($users as $user) {
            User::Create($user);
        }
    }
}
