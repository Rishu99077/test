<?php
namespace App\Models;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Model;

class JobsModel extends Model{
    protected $table = 'jobs';
    protected $fillable = [
        "job_type_id",
        "title",
        "salary",
        "profession_name",
        "experience",
        "working_hours",
        "work_location",
        "start_date",
        "requirements",
        "description",
        "driving_license",
        "own_car",
        "status",
        "customer_id",
    ];




    public function newtimeago($newdate){
      $timestamp = strtotime($newdate); 
    
      $newtimeago = '';
      $strTime = array("second", "minute", "hour", "day", "month", "year");
      $ago = 'ago';
      $length = array("60","60","24","30","12","10");        
      $currentTime = time();
      if($currentTime >= $timestamp) {
        $diff     = time()- $timestamp;
        for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
          $diff = $diff / $length[$i];
        }
        $diff = round($diff);
        $newtimeago =  $diff . " " . $strTime[$i] .' '.$ago;
      }
     
      return $newtimeago;
    }


    public function MyJobs(){
        $cust_id = Session::get('cust_id');
        $jobs_id        = array();
        $JobsModel      = JobsModel::where('customer_id',$cust_id)->get();
        foreach($JobsModel as $key => $job){
                $jobs_id[] = $job['id'];
        }

        return $jobs_id;
    }
}