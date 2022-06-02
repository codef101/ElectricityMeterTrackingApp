<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumption extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'consumptions';
    protected $primaryKey = 'id';
    protected $fillable = ['Date','BuildingName','ConsumerName','MeterNumber','TotalVolume','TotalUnits','PrincipleAmount','PrincipleAmountExclVat','VAT','ArrearsAmount','TarrifIndex','updated_at'];

    public function consumption()
    {
        return $this->belongsTo(Meter::class, 'meter_id');
    }
}
