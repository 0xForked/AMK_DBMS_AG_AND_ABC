<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 5; $i++) {
            DB::table('offices')->insert($this->dataOffices());
            $office_id = DB::getPdo()->lastInsertId();
            for ($u = 0; $u <= 10; $u++) {
                DB::table('employees')->insert($this->dataEmployee($office_id, $i, $u));
            }
        }
    }

    private function dataOffices(): array
    {
        $faker = Faker\Factory::create();

        return [
            'city' => $faker->city,
            'phone' => $faker->e164PhoneNumber,
            'address_line_1' => $faker->address,
            'address_line_2' => $faker->secondaryAddress,
            'state' => $faker->state,
            'country' => $faker->country,
            'postal_code' => $faker->postcode,
            'territory' => $faker->buildingNumber,
        ];
    }

    private function dataEmployee(int $office_id, int $current_opos, int $current_epos): array
    {
        $faker = Faker\Factory::create();
        $rep = 0;

        switch ($current_opos) {
            case 0:
                $rep = 1;
                break;
            case 1:
                $rep = 12;
                break;
            case 2:
                $rep = 23;
                break;
            case 3:
                $rep = 34;
                break;
            case 4:
                $rep = 45;
                break;
            case 5:
                $rep = 56;
                break;
        }

        return [
            'office_id' => $office_id,
            'report_to_id' => ($current_epos == 0) ? null : $rep,
            'uuid' => $faker->uuid,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'extension' => $faker->randomNumber(001, 999),
            'email' => $faker->email,
            'job_title' => ($current_epos == 0) ? 'manager' : 'sales'
        ];

    }
}
