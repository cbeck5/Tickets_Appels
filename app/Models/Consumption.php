<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Consumption extends Model
{

    protected $table = 'consumption';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'abonne_id',
        'type_consumption',
        'date_consumption',
        'time_consumption',
        'duration_real_consumption',
        'duration_invoiced_consumption'
    ];



}
