<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_line_id')
                ->nullable()
                ->constrained('product_lines')
                ->references('id')
                ->onDelete('SET NULL');
            $table->string('code');
            $table->string('name');
            $table->string('scale');
            $table->string('vendor');
            $table->text('description');
            $table->integer('qty_in_price');
            $table->integer('buy_price');
            $table->string('MSRP');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
