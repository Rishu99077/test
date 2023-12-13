<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class WorkModel extends Model{
    protected $table = 'how_work';
    protected $fillable = [
        "image",
        "logo",
        "status",
        "role",
    ];
}