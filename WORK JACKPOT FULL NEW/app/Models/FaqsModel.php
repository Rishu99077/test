<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FaqsModel extends Model{
    protected $table = 'faqs';
    protected $fillable = [
        "status",
    ];
}