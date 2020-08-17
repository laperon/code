<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company',
        'budget' ,
        'status' ,
        'views',
        'interactions' ,
        'views_interactions',
        'average_cost' ,
        'price' ,
        'average_cost_for_view',
        'average_cost_for_thousand_views' ,
        'average_cost_views_displays' ,
        'company_type' ,
        'average_price_for_click' ,
    ];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

}
