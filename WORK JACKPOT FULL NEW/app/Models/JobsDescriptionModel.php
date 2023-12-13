<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class JobsDescriptionModel extends Model{
    protected $table = 'faqs';
    protected $fillable = [
        "status",
    ];
}