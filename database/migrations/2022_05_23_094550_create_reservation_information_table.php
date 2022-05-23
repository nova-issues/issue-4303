<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained();
            $table->foreignId('circuit_id')->constrained();
            $table->date('received_on');
            $table->decimal('total_eur')->default(0);
            $table->decimal('total_sell')->default(0)->comment('value in dirhams');
            $table->decimal('total_buy')->default(0)->comment('value in dirhams');
            $table->boolean('voucher')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservation_information');
    }
};
