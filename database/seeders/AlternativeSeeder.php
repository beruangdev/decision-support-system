<?php

namespace Database\Seeders;

use App\Models\Alternative;
use App\Models\AlternativeTaxonomie;
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
        $alternatives = [];
        for ($i = 0; $i < 200; $i++) {
            $faker = Faker::create('id_ID');
            $alternative = new Alternative();
            $alternative->name = $faker->name();
            $alternative->description = $faker->paragraph($faker->numberBetween(1, 5));
            $alternative->user_id = 1;
            $alternative->save();
            array_push($alternatives, $alternative);
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

        foreach ($alternatives as $index => $alternative) {
            $alternative_taxonomies = [];
            $taxonomie_strings = [];
            foreach ($criterias as $key => $criteria) {
                if ($faker->numberBetween(1, 10) >= 10) continue;

                $value = $faker->numberBetween($criteria["numberBetween"][0], $criteria["numberBetween"][1]);
                array_push($alternative_taxonomies, [
                    "key" => $criteria["key"],
                    "key_slug" => Str::slug($criteria["key"]),
                    "value" => $value,
                    "value_slug" => Str::slug($value),
                    "order" => $key + 1,
                    "alternative_id" => $alternative->id,
                    "user_id" => 1,
                ]);
                array_push($taxonomie_strings, Str::slug($criteria["key"]) . "=" . Str::slug($value));
            }
            if (count($alternative_taxonomies)) {
                AlternativeTaxonomie::insert($alternative_taxonomies);
                $alternative->taxonomie_strings = join(",", $taxonomie_strings);
                $alternative->save();
            }
        }
    }
}
