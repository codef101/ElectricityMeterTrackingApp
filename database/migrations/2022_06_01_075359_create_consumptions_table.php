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
        if(!Schema::hasTable('consumptions'))
        {
            Schema::create('consumptions', function (Blueprint $table)
            {
            $table->bigIncrements("id");
            $table->string("Date")->nullable();
            $table->string("BuildingName")->nullable();
            $table->string("ConsumerName")->nullable();
            $table->string("MeterNumber")->nullable();
            $table->string("TotalVolume")->nullable();
            $table->string("TotalUnits")->nullable();
            $table->string("PrincipleAmount")->nullable();
            $table->string("PrincipleAmountExclVat")->nullable();
            $table->string("VAT")->nullable();
            $table->string("ArrearsAmount")->nullable();
            $table->string("TarrifIndex")->nullable();
            $table->timestamps();
            });
        }


        Schema::table('consumptions', function (Blueprint $table) {
            $table->unsignedBigInteger('meter_id');//->default("UNALLOCATED")->change()
            $table->foreign('meter_id')->references('id')->on('meters');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consumptions');
    }
};
