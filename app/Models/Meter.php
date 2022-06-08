<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meter extends Model
{
    use HasFactory;

    protected $fillable = ['MeterNumber'];

    public function consumption()
    {
        return $this->hasOne(Consumption::class);
    }

    public function consumer()
    {
        return $this->belongsTo(Consumer::class);
    }
}
