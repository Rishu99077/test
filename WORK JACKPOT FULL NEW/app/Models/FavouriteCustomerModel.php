<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FavouriteCustomerModel extends Model{
    protected $table = 'favourite_customers';
    protected $fillable = [
        "customer_id",
        "provider_id",
    ];
}