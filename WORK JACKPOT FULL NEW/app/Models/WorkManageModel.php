<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class WorkManageModel extends Model{
    protected $table = 'work_management';
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
