<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProductCategorieModel extends Model
{
    protected $table = 'product_categorie';
    protected $fillable = [
        "categorie_name",
        "product_type_id",
        "status",
        "User_ID",
        "admin_id",
        "superadmin_id",
    ];

}

