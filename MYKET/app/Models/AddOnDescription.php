<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddOnDescription extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = "add_on_description";
}
