<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MeterNumber extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'meternumbertable';
    protected $primaryKey = 'MeterID';
    protected $fillable = ['MeterID','Date','BuildingName','ConsumerName','MeterNumber','TotalVolume','TotalUnits','PrincipleAmount','PrincipleAmountExclVat','VAT','ArrearsAmount','TarrifIndex','updated_at'];

    protected $guarded = [];

    public static function search($search)
    {
        //if search is empty (by default)
        return empty($search) ? static::query()
            : static::query()->where('id','like','%'.$search.'%')
                ->orWhere('Date','like','%'.$search.'%')
                ->orWhere('BuildingName','like','%'.$search.'%')
                ->orWhere('ConsumerName','like','%'.$search.'%')
                ->orWhere('MeterNumber','like','%'.$search.'%');
    }
    public function consumer()
    {
        return $this->belongsTo(Consumer::class);
    }
}
