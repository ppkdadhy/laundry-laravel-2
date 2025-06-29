<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Pest\ArchPresets\Custom;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 8; $i++) { 
            Customer::create([
                'customer_name' => fake()->name(), 
                'address' => fake()->address(), 
                'phone' => fake()->phoneNumber()
            ]);
        }
    }
}
