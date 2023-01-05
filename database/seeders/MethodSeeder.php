<?php

namespace Database\Seeders;

use App\Models\Method;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $methods = [
            "Analytic Hierarchy Process (AHP)", 
            "Simple Additive Weighting (SAW)",
            "Weighted Product (WP)",
            "Technique for Order by Similarity to Ideal Solution (TOPSIS)",
            "Multi-Attribute Utility Theory (MAUT)",
            "Multi-Objective Optimization on the basis of Ratio Analysis (MOORA)",
            "Multi Attribute Decision Making (MADM)",
            
        ];
        foreach ($methods as $key => $value) {
            $method = new Method();
            $method->name = $value;
            $method->slug = Str::slug($value);
            $method->save();
        }
    }
}
