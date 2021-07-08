<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i=0; $i<=1000; $i++) {
            $first_name = $faker->firstName;
            $last_name = $faker->lastName;
            $name = "$first_name $last_name";

            DB::table('customers')->insert([
                'employee_id' => $faker->numberBetween(1, 66),
                'uuid' => $faker->uuid,
                'full_name' => $name,
                'contact_first_name' => $first_name,
                'contact_last_name' => $last_name,
                'phone' => $faker->e164PhoneNumber,
                'address_line_1' => $faker->address,
                'address_line_2' => $faker->secondaryAddress,
                'city' => $faker->city,
                'state' => $faker->state,
                'postal_code' => $faker->postcode,
                'country' => $faker->country,
                'credit_limit' => substr($faker->numberBetween(1000000, 100000000), 0, -4) . '0000',
            ]);
        }
    }
}
