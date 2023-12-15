<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ProductTypeModel extends Model
{
    protected $table = 'product_type';
    protected $fillable = [
        "name",
        "icon",
        "status",
        "User_ID",
        "admin_id",
        "superadmin_id",
        "source",
    ];

}

