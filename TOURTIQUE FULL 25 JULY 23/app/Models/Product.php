<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    public function get_product_images()
    {
        return $this->hasMany(ProductImages::class, "product_id", "id");
    }
}
