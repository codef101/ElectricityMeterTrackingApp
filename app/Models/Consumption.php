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

    protected $fillable = ['Date','BuildingName','TotalVolume','TotalUnits','PrincipleAmount','PrincipleAmountExclVat','VAT','ArrearsAmount','TarrifIndex','updated_at'];


    public function meter()
    {
        return $this->belongsTo(Meter::class);
    }

}
