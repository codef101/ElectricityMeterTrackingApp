<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Consumer;
use App\Models\Meter;

class MeterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $consumer = Consumer::find(1);
        $meter = new Meter();
        $meter->MeterNumber = 1234567890;
        $meter->consumer_id = $consumer->id;
        $meter->save();

    }
}
