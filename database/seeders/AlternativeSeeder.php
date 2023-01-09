<?php

namespace Database\Seeders;

use App\Models\Alternative;
use App\Models\AlternativeTaxonomie;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class AlternativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project_count = Project::count();
        $alternatives = [];
        for ($i = 0; $i < intval(env("ALTERNATIVE_COUNT", 0)); $i++) {
            $faker = Faker::create('id_ID');
            $alternative = new Alternative();
            $alternative->name = $faker->name();
            $alternative->description = $faker->paragraph($faker->numberBetween(1, 5));
            $alternative->project_id = $faker->numberBetween(1, $project_count);
            $alternative->user_id = 1;
            $alternative->save();
            $alternatives[] = $alternative;
        }


        $criterias = [
            [
                "key" => "Jumlah rata-rata pemasukan bulanan",
                "numberBetween" => [700000, 4000000]
            ],
            [
                "key" => "Jumlah anggota keluarga",
                "numberBetween" => [1, 8]
            ],
            [
                "key" => "Jumlah rata-rata pengeluaran bulanan",
                "numberBetween" => [700000, 4000000]
            ],
            [
                "key" => "Luas lantai perkapita",
                "numberBetween" => [4, 20]
            ],
            [
                "key" => "Pembayaran rata-rata listrik perbulan",
                "numberBetween" => [30000, 600000]
            ],
        ];

        $new_alternatives = [];
        foreach ($alternatives as $index => $alternative) {
            $taxonomie_strings = [];
            foreach ($criterias as $key => $criteria) {
                if ($faker->numberBetween(1, 10) >= 10) continue;

                $value = $faker->numberBetween($criteria["numberBetween"][0], $criteria["numberBetween"][1]);
                $taxonomie_strings[] = [$criteria["key"] => $value];
            }
            $alternative->attributes = collect($taxonomie_strings)->toJson();
            $new_alternatives[] = $alternative;
        }

        Alternative::insert($new_alternatives);
    }
}
