<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    private $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }

    public function run()
    {
        for ($i = 0; $i <= 10000; $i++) {
            $order = $this->dataOrder();
            DB::table('orders')->insert($order);
            $order_id = DB::getPdo()->lastInsertId();

            for ($e = 0; $e <= $this->faker->numberBetween(1, 15); $e++) {
                $product_random = $this->faker->numberBetween(1, 80);
                $product = DB::table('products')
                    ->where('id', $product_random)
                    ->first();

                if ($product->qty_in_price !== 0) {
                    $order_detail = $this->dataOrderDetail($order_id, $product);

                    DB::table('order_details')
                        ->insert($order_detail);

                    DB::table('products')
                        ->where('id', $product->id)
                        ->update(['qty_in_price' => ($product->qty_in_price - $order_detail['qty_ordered'])]);
                }
            }

            if ($order['status'] !== 'ISSUED') {
                DB::table('payments')->insert($this->dataPayment(
                    $order_id,
                    Carbon::createFromFormat('Y-m-d H:i:s', $order['order_date'])
                        ->addDays($this->faker->numberBetween(1,2))
                ));
            }
        }
    }

    private function dataOrder(): array
    {
        $startDate = Carbon::createFromTimeStamp($this->faker->dateTimeBetween('-620 days', '+10 days')->getTimestamp());

        return [
            'customer_id' => $this->faker->numberBetween(1, 1000),
            'order_date' => $startDate,
            'required_date' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate)->addDays(30),
            'shipped_date' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate)->addDays(3),
            'status' => $this->faker->randomElement(['ISSUED', 'PAYMENT', 'SHIPPED']),
            'comments' => $this->faker->word,
        ];
    }

    private function dataOrderDetail(int $order_id, $product): array
    {
        return [
            'order_id' => $order_id,
            'product_id' => $product->id,
            'qty_ordered' => $this->faker->numberBetween(1, ($product->qty_in_price < 15) ? $product->qty_in_price : 10),
            'price_each' => $product->buy_price,
        ];
    }

    private function dataPayment(int $order_id, $date): array
    {
        $order_detail = DB::table('order_details')
            ->where('order_id', $order_id)
            ->get();

        $price = 0;
        foreach ($order_detail as $detail) {
            $price += ($detail->qty_ordered * $detail->price_each);
        }

        return [
            'order_id' => $order_id,
            'check_number' => "PAY" . $this->faker->numberBetween(100000, 9999999),
            'payment_date' => $date,
            'amount' => $price,
        ];
    }
}
