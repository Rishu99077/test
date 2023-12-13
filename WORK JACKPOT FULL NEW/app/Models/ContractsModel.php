<?php
namespace App\Models;
use App\Models\JobsModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class ContractsModel extends Model{
    protected $table = 'contracts';
    protected $fillable = [
        "job_id",
        "customer_id",
        "status",
    ];
   



    public function MyContracts(){
        $cust_id = Session::get('cust_id');
        $jobs_id = array();
        $JobsModel      = JobsModel::where('customer_id',$cust_id)->get();
        foreach($JobsModel as $key => $job){
                $jobs_id[] = $job['id'];
        }

        $ContractsModel = ContractsModel::select('contracts.*','contracts.id AS contract_id','customers.*',)
                                            ->leftJoin('customers','customers.id','=','contracts.customer_id')
                                            ->leftJoin('jobs','jobs.id','=','contracts.job_id')
                                            ->whereIn('job_id',$jobs_id)
                                            ->where(['role' => 'seeker']);
        

        return $ContractsModel;


    }
}