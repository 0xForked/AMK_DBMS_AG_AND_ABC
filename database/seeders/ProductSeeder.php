<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->dataProductLine() as $line) {
            DB::table('product_lines')->insert($line);
            $line_id = DB::getPdo()->lastInsertId();
            for ($i = 0; $i <= 15; $i++) {
                DB::table('products')->insert($this->dataProduct($line_id));
            }
        }
    }

    private function dataProductLine(): array
    {
        return [
            ['text_description' => 'milk'],
            ['text_description' => 'cheese'],
            ['text_description' => 'butter'],
            ['text_description' => 'coffee'],
            ['text_description' => 'soda'],
        ];
    }

    private function dataProduct(Int $line_id): array
    {
        $faker = Faker\Factory::create();
        $price = substr($faker->numberBetween(10000, 100000), 0, -3) . '000';
        $percentage = $price * (15 / 100);

        return [
            'product_line_id' => $line_id,
            'code' => "SKU{$faker->numberBetween(0001, 9999)}",
            'name' => $faker->word,
            'scale' => $faker->word,
            'vendor' => $faker->text,
            'description' => $faker->sentence,
            'qty_in_price' => $faker->numberBetween(0001, 9999),
            'buy_price' => $price,
            'MSRP' => $price - $percentage,
        ];
    }
}
