<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProductsModel extends Model
{
    protected $table = 'products';

    protected $fillable = [

        "product_name",
        "product_code",
        "vendor_code",
        "product_type_id",
        "product_categorie_id",
        "container_type",
        "container_size",
        "presentation",
        "units",
        "wholesale_container_price",
        "single_portion_size",
        "single_portion_unit",
        "retail_portion_price",
        "full_weight",
        "empty_weight",
        "case_size",
        "vendor_id",
        "par",
        "reorder_point",
        "order_by_the",
        "ideal_pour_cost",
        "status",
        "User_ID",
        "admin_id",
        "superadmin_id",
        "source",
    ];

}

