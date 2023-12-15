<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SideBanner extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = "side_banner";
}
