<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumer extends Model
{
    use HasFactory;

    protected $fillable = ['ConsumerName'];

    public function meter()
    {
        return $this->hasMany(Meter::class);
    }
}
