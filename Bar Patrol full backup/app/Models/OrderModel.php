<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model{
    protected $table = 'order';
    protected $fillable = [
    	"Order",
        "order_status",
        "User_ID",
    ];

}

