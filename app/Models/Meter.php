<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'meters';
    protected $primaryKey = 'id';
    protected $fillable = ['MeterNumber'];

    protected $guarded = [];

    public function consumption()
    {
        return $this->belongsTo(Consumption::class);
    }

    public function consumer()
    {
        return $this->belongsTo(Consumer::class);
    }
}
