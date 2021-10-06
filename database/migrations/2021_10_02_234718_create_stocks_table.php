<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('color');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->text('photo');
            $table->integer('count')->default(1);
            $table->float('price');
            $table->float('discount')->nullabale();
            $table->enum('size', ['xxs', 'xs', 's', 'm', 'l', 'xl', '2xl', '3xl'])->default('m');
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
        Schema::dropIfExists('stocks');
    }
}
