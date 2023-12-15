<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IconsModel extends Model{
    protected $table = 'icons';
    protected $fillable = [
        "icon_name",
        "image",
        "User_ID",
        "status",
        "admin_id",
        "superadmin_id",
    ];

}

