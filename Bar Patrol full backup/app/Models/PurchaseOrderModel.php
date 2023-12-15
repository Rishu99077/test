<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderModel extends Model{
    protected $table = 'purchase_order';
    protected $fillable = [
    	"OrderID",
        "order_id",
        "product_name",
        "vendor_id",
        "product_id",
        "order_by",
        "case_size",
        "quantity",
        "wholesale_value",
        "User_ID",
    ];

}

