<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $request_projects = [
            "BANSOS Aceh Barat 2021",
            "Penerima Beasiswa UNSYIAH 2022",
            "FAKIR Aceh 2020",
            "ODGJ Banda Aceh 2022",
        ];

        foreach ($request_projects as $request_project) {
            $faker = Faker::create('id_ID');
            $project = new Project();
            $project->name = $request_project;
            $project->description = $faker->paragraph($faker->numberBetween(2, 5));
            $project->user_id = 1;
            $project->save();
        }
    }
}
