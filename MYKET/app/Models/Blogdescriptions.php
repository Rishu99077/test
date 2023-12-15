<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogdescriptions extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = "blog_descriptions";
}
