<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LocationsModel extends Model
{
    protected $table = 'locations';
    protected $fillable = [
        "location_name",
        "User_ID",
        "status",
        "admin_id",
        "superadmin_id",
        "source",
    ];
}

