<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRestriction extends Model
{
    use HasFactory;
    protected $table = "product_not_suitable";
}
