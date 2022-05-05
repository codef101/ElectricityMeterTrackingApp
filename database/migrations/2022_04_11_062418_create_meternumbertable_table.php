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
        Schema::create('meternumbertable', function (Blueprint $table) {
            $table->increments("MeterID");
            $table->string("Date");
            $table->string("BuildingName");
            $table->string("Consumer");
            $table->string("MeterNumber");
            $table->string("TotalVolume");
            $table->string("TotalUnits");
            $table->string("PrincipleAmount");
            $table->string("PrincipleAmountExclVat");
            $table->string("VAT");
            $table->string("ArrearsAmount");
            $table->string("TarrifIndex");
        });

        Schema::create('consumertable', function (Blueprint $table) {
            $table->increments("id");
            $table->string("ConsumerName");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meternumbertable');
        Schema::dropIfExists('consumertable');
    }
};
