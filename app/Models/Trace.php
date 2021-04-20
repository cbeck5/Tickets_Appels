<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Trace extends Model
{

    protected $table = 'trace';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'message'
    ];



}
