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

    /*public function meter()
    {
        return $this->hasOne(Meter::class);
    }*/

    /**
     * Get all of the conusmer names for the Consumption
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    /*public function consumers()
    {
        return $this->hasManyThrough(Consumer::class, Meter::class);//first parameter is the model we want to access and the 2nd param is the intermidiete table
    }*/

    /**
     * The model's default values for attributes.
     * Maybe i could use this to set the foriegn key "meter_id"
     *
     * @var array
     */
    /*public function SetMeterNumbers()
    {
        $meters = Meter::with('consumptions')->get();
    }

    protected $attributes = [
        'meter_id' => 'MyForeignKeyedValue',
    ];*/
}
