<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            [
                'level_name' => 'Administrator'
            ],[
                'level_name' => 'Operator'
            ],[
                'level_name' => 'Pimpinan'
            ]
        ];

        foreach ($levels as $key => $value) {
            Level::create(
                [
                    'level_name' => $value['level_name']
                ]
            );
        }
    }
}
