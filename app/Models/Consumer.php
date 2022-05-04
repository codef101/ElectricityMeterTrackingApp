<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumer extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = "consumertable";
    protected $primaryKey = 'id';
    protected $fillable = ['ConsumerName'];

    protected $guarded = [];

}
