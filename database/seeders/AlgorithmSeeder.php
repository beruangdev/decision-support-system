<?php

namespace Database\Seeders;

use App\Models\Algorithm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlgorithmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new Algorithm();
        $user->name = "Evaluation based on Distance from Average Solution (EDAS)";
        $user->save();
    }
}
