<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class InventriesProductModel extends Model
{
    protected $table = 'inventries_products';
    protected $fillable = [
    	"InventryID",
        "product_id",
        "product_name",
        "location_id",
        "location_name",
        "quantity_type",
        "case_size",
        "quantity",
        "weight",
        "whole_sale_value",
        "retail_value",  
        "User_ID",
    ];

}

