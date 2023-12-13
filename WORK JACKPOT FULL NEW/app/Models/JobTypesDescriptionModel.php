<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class JobTypesDescriptionModel extends Model{
    protected $table = 'job_types_description';
    protected $fillable = [
        "job_type_id",
        "title",
        "description",
        "language_id",
    ];
}