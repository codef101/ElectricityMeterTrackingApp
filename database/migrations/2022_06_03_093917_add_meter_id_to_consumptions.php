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
        Schema::table('consumptions', function (Blueprint $table) {
            $table->unsignedBigInteger('meter_id')->after('TarrifIndex');
            $table->foreign('meter_id')->references('id')->on('meters');
        });
    }
};
