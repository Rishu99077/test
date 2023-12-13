<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TestimonialDescriptionModel extends Model{
    protected $table = 'testmonials_description';
    protected $fillable = [
        "testimonial_id",
        "name",
        "designation",
        "description",
        "language_id",
    ];
}