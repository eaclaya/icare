<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['street', 'state', 'city', 'zip', 'county', 'country', 'lat', 'lng'];
}
