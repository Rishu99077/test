<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class JobsFavouriteModel extends Model{
    protected $table = 'jobs_favourite';
    protected $fillable = [
        "job_id",
        "customer_id",
    ];
}