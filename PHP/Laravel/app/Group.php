<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'announcement_group_status',
        'announcement_group',
        'status',
        'currency_code',
        'max_price_per_view',
        'views',
        'currency_code2',
        'average_price_per_viewer',
        'ad_group_type',
        'shows',
        'coff_views',
        'cost',
        'additional_views',
        'conversions',
        'cost_conversion',
        'conversion_coeff',
    ];
}
