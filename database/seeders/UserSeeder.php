<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "Admin";
        $user->email = "admin@local.com";
        $user->role = "admin";
        $user->password = bcrypt('12345678');
        $user->save();

        $user = new User();
        $user->name = "User";
        $user->email = "user@local.com";
        $user->role = "user";
        $user->password = bcrypt('12345678');
        $user->save();
    }
}
