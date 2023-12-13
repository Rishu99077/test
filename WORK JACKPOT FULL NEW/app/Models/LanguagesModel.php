<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LanguagesModel extends Model{
    protected $table = 'languages';
    protected $fillable = [
        "name",
        "short_name",
        "status",
    ];
}