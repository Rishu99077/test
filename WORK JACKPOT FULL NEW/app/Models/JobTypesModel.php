<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class JobTypesModel extends Model{
    protected $table = 'job_types';
    protected $fillable = [
        "status",
    ];
}