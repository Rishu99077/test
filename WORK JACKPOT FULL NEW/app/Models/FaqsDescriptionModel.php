<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FaqsDescriptionModel extends Model{
    protected $table = 'faqs_description';
    protected $fillable = [
        "faq_id",
        "title",
        "description",
        "language_id",
    ];
}