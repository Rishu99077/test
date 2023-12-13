<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ReportsModel extends Model{
    protected $table = 'reports';
    protected $fillable = [
        "contract",
        "working_hours",
        "working_amount",
        "start_date",
        "end_date",
        "document",
        "customer_id",
    ];
}
