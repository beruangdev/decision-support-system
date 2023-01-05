<?php

namespace Database\Seeders;

use App\Models\Algorithm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AlgorithmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $algorithms = [
            "Evaluation based on Distance from Average Solution (EDAS)",
            "Visekriterijumsko. Kompromisno Rangiranje (VIKOR)",
            "Weight Aggregated Sum Product Assesment (WASPA)",
            "Simple Multi Attribute Rating Technique (SMART)",
            
        ];
        foreach ($algorithms as $key => $value) {
            $algorithm = new Algorithm();
            $algorithm->name = $value;
            $algorithm->slug = Str::slug($value);
            $algorithm->save();
        }
    }
}
