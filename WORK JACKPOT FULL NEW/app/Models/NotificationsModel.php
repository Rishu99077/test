<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class NotificationsModel extends Model{
    protected $table = 'notifications';
    protected $fillable = [
        "cust_id",
        "customer_name",
        "customer_phone",
        "customer_email",
        "message",
    ];
}