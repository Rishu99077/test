<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class WorkDescriptionModel extends Model{
    protected $table = 'how_work_description';
    protected $fillable = [
        "work_id",
        "title",
        "description",
        "language_id",
    ];
}