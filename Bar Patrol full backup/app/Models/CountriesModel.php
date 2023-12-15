<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountriesModel extends Model
{
    protected $table = 'countries';
    protected $fillable = [
        "sortname",
        "name",
        "phonecode",
    ];
}