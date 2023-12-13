<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class JobRequirementsModel extends Model{
    protected $table = 'job_requirements';
    protected $fillable = [
        "job_id",
        "requirements",
    ];
}