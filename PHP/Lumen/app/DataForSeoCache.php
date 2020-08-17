<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataForSeoCache extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['website','api_request_date','hash_id','data'];

    public $timestamps = false;

    /**
     * Return data by website
     *
     * @param $website
     * @return mixed
     */
    public function getDataByWebsite($website)
    {
        return $this->where('website' , $website)->get();
    }
}
