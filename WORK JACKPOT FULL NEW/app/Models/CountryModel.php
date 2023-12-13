<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CountryModel extends Model{
    protected $table = 'countries';
    protected $fillable = [
        "name",
        "sortname",
        "phonecode",
        "status",
    ];
}