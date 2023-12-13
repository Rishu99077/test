<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptions extends Model
{
    use HasFactory;
    protected $table = 'products_options';

    public function get_product_option_details()
    {
        return $this->hasMany(ProductOptionDetails::class, "product_option_id", "id");
    }
}
