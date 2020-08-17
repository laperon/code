<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestEmail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email','website'];

    public $timestamps = false;
}
