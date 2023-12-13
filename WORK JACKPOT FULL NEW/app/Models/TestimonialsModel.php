<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TestimonialsModel extends Model{
    protected $table = 'testmonials';
    protected $fillable = [
        "image",
        "status",
    ];
}