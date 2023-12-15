<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class InventriesModel extends Model
{
    protected $table = 'inventries';
    protected $fillable = [
    	"location_id",
        "location",
        "description",
        "date",
        "inventrie_notes",
        "vendor_id",
        "User_ID",

    ];
}

