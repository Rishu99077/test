<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Users;
use App\Models\UserDescription;
use App\Models\RequestModel;
use Mail;
use Illuminate\Support\Facades\Hash;

class RequestController extends Controller{

	public function send_request(Request $request){
	  $output=array();
	  $output['status']=false;
	  if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){
			$validation = Validator::make($request->all(), [
				'user_id'  		=> 'required',
				'password'  	=> 'required',
				'to_user_id'  	=> 'required',
			]);

			if ($validation->fails()) {
				$output['message'] = $validation->errors()->first();
				return response()->json($output); die;
			}

			if ($request->user_id == $request->to_user_id) {
				$output['message'] = 'You Can not add yourself';
				return response()->json($output); die;
			}				
			$customer = Users::where(['id' => $request->user_id])->whereNull('is_delete')->first();
			$to_customer = Users::where(['id' => $request->to_user_id])->whereNull('is_delete')->first();
			
			if ($customer) {
				if ($customer->password==$request->password) {
					
					$Pending_request = RequestModel::whereNull('is_delete')->where('status','Pending')->where(['user_id' => $request->to_user_id,'to_user_id' => $request->user_id])->first();
					if ($Pending_request){
						$Pending_request->status   = 'Accept';
						$Pending_request->save();
					}else{
						$get_request = RequestModel::whereNull('is_delete')->where(['user_id' => $request->user_id,'to_user_id' => $request->to_user_id])->first();
						if ($get_request) {
							/*if ($get_request->status=='Accept') {
								$output['status']  = true;
								$output['message'] = 'Request Send successfully';
							}else{
								$RequestModel = RequestModel::find($get_request->id);
								$RequestModel->user_id       	= $request->user_id;
								$RequestModel->customer_status      = 'Send';
								$RequestModel->to_user_id       = $request->to_user_id;
								$RequestModel->trip_id       = $request->trip_id;
								$RequestModel->status   = 'Pending';
								$RequestModel->save();
								$output['status']  = true;
								$output['message'] = 'Request Send successfully'; 
								fcmtoken($request->to_user_id,$customer->full_name.' have send new request.');
							}*/
						}else{
							$RequestModel = new RequestModel();
							$RequestModel->user_id       	= $request->user_id;
							$RequestModel->customer_status      = 'Send';
							$RequestModel->to_user_id       = $request->to_user_id;
							$RequestModel->status   = 'Pending';
							$RequestModel->str_time   = time();
							$RequestModel->save();
						}
					}
					$output['status']  = true;
					$output['message'] = 'Request Send successfully';
				} else {
					$output['message'] = '401 ffd';
				}
			} else {
				$output['message'] = '401';
			}
	  	}else{
	    	$output['message'] = '405';
	  	}
	  	return response()->json($output); die;
	}

	public function accept_request(Request $request){
	  	$output=array();
	  	$output['status']=false;
	  	if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){
			$validation = Validator::make($request->all(), [
				'user_id'  		=> 'required',
				'password'  	=> 'required',
				'to_user_id'  	=> 'required',
			]);

			if ($validation->fails()) {
				$output['message'] = $validation->errors()->first();
				return response()->json($output); die;
			}

			$customer = Users::where(['id' => $request->user_id])->whereNull('is_delete')->first();
			$to_customer = Users::where(['id' => $request->to_user_id])->whereNull('is_delete')->first();
			if ($customer) {
				if ($customer->password==$request->password) {
					$to_customer = Users::where(['id' => $request->to_user_id])->whereNull('is_delete')->first();
					$get_request = RequestModel::whereNull('is_delete')->where(['user_id' => $request->to_user_id,'to_user_id' => $request->user_id])->first();
					if ($get_request) {
						if ($get_request->status=='Pending') {
							$RequestModel = RequestModel::find($get_request->id);
							$RequestModel->status   = 'Accept';
							$RequestModel->save();

							$output['status']  = true;
							$output['message'] = 'Request Accept successfully';	
						}else{
							$output['message'] = 'Request not found';
						}	
					}else{
						$output['message'] = 'Request not found';
					}
				} else {
					$output['message'] = '401';
				}			
			} else {
				$output['message'] = '401';
			}
		}else{
	      $output['message'] = '405';
	  	}
	  	return response()->json($output); die;
	}

	public function reject_request(Request $request){
	  $output=array();
	  $output['status']=false;
	  if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

			$validation = Validator::make($request->all(), [
				'user_id'  		=> 'required',
				'password'  		=> 'required',
				'to_user_id'  	=> 'required',
			]);

			if ($validation->fails()) {
				$output['message'] = $validation->errors()->first();
				return response()->json($output); die;
			}
			$customer = Users::where(['id' => $request->user_id ])->whereNull('is_delete')->first();
			if ($customer) {
				if ($customer->password==$request->password) {
					$to_customer = Users::where(['id' => $request->to_user_id ])->whereNull('is_delete')->first();
					$RequestModel = RequestModel::whereNull('is_delete')->where(['to_user_id' => $request->user_id,'user_id' => $request->to_user_id])->first();
					if ($RequestModel) {
						$RequestModel->status    = 'Reject';
						$RequestModel->is_delete = 1;
						$RequestModel->save();

						$output['status']  = true;
						$output['message'] = 'Request Rejected';
					}else{
						$output['message'] = 'Request not found';
					}
				} else {
					$output['message'] = '401';
				}	
			} else {
				$output['message'] = '401';
			}
	  }else{
	      $output['message'] = '405';
	  }
	  return response()->json($output); die;
	}

    public function friend_list(Request $request){
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validation = Validator::make($request->all(), [
              'user_id'      => 'required',
              'password'        => 'required',
            ]);

            if ($validation->fails()) {
              $output['message'] = $validation->errors()->first();
              return response()->json($output); die;
            }

            $data = array();
            $customer = Users::where(['id' => $request->user_id])->whereNull('is_delete')->first();
			if ($customer) {
				if ($request->password==$customer->password) { 

		            $user_id =$request->user_id;

		            $query = RequestModel::whereNull('is_delete')->where('status','Accept');
			        $query->where(function ($query) use ($user_id) {
			            $query->orWhere('user_id',$user_id);
			            $query->orWhere('to_user_id',$user_id);
			        });    
			        $query->orderBy('id', 'DESC');
			        $get_accept_reqest = $query->get();


	            	foreach ($get_accept_reqest as $key => $value) {

	            		if ($request->user_id==$value->user_id) {
					  		$customer = Users::where(['id' => $value->to_user_id])->whereNull('is_delete')->first();
					        $get_usersdata_data = array();
					        $get_usersdata_data['user_id']      = $customer['id'];
					        $get_usersdata_data['full_name']        = $customer['first_name'].' '.$customer['last_name'];
					        $get_usersdata_data['email']            = $customer['email'];
					        $get_usersdata_data['phone_number']     = $customer['contact'];
					        $get_usersdata_data['company_name']     = $customer['company_name'];
					        $get_usersdata_data['image']            = $customer['image'] != '' ? url('uploads/users', $customer['image']) : asset('frontassets/image/placeholder.jpg');
	            		}else{
					  		$customer = Users::where(['id' => $value->user_id])->whereNull('is_delete')->first();
					        $get_usersdata_data = array();
					        $get_usersdata_data['user_id']      = $customer['id'];
					        $get_usersdata_data['full_name']        = $customer['first_name'].' '.$customer['last_name'];
					        $get_usersdata_data['email']            = $customer['email'];
					        $get_usersdata_data['phone_number']     = $customer['contact'];
					        $get_usersdata_data['company_name']     = $customer['company_name'];
					        $get_usersdata_data['image']            = $customer['image'] != '' ? url('uploads/users', $customer['image']) : asset('frontassets/image/placeholder.jpg');
	            		}

	            		if ($get_usersdata_data) {
					  		$data[] = $get_usersdata_data;
	            		}
	            	}
	                  
	                $output['status']  = true;
	                $output['data']    = $data;
	                $output['message'] = 'Friend list';
	        	} else {
					$output['message'] = '401';
				} 
	        } else {
				$output['message'] = '401';
			}    
        }else{
            $output['message'] = '405';
        }
        return response()->json($output); die;
    }

    public function my_request(Request $request){
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validation = Validator::make($request->all(), [
              'user_id'      => 'required',
              'password'        => 'required',
            ]);

            if ($validation->fails()) {
              $output['message'] = $validation->errors()->first();
              return response()->json($output); die;
            }

            $data = array();
            $customer = Users::where(['id' => $request->user_id])->whereNull('is_delete')->first();
			if ($customer) {
				if ($request->password==$customer->password) { 

		            $user_id =$request->user_id;

		            $query = RequestModel::whereNull('is_delete')->where('status','Pending');
			        $query->where(function ($query) use ($user_id) {
			            // $query->orWhere('user_id',$user_id);
			            $query->orWhere('to_user_id',$user_id);
			        });    
			        $query->orderBy('id', 'DESC');
			        $get_accept_reqest = $query->get();


	            	foreach ($get_accept_reqest as $key => $value) {

	            		if ($request->user_id==$value->user_id) {
					  		$customer = Users::where(['id' => $value->to_user_id])->whereNull('is_delete')->first();
					        $get_usersdata_data = array();
					        $get_usersdata_data['id']          		= $customer['id'];
					        $get_usersdata_data['full_name']        = $customer['first_name'].' '.$customer['last_name'];
					        $get_usersdata_data['email']            = $customer['email'];
					        $get_usersdata_data['phone_number']     = $customer['contact'];
					        $get_usersdata_data['company_name']     = $customer['company_name'];
					        $get_usersdata_data['image']            = $customer['image'] != '' ? url('uploads/users', $customer['image']) : asset('frontassets/image/placeholder.jpg');
	            		}else{
					  		$customer = Users::where(['id' => $value->user_id])->whereNull('is_delete')->first();
					        $get_usersdata_data = array();
					        $get_usersdata_data['id']               = $customer['id'];
					        $get_usersdata_data['full_name']        = $customer['first_name'].' '.$customer['last_name'];
					        $get_usersdata_data['email']            = $customer['email'];
					        $get_usersdata_data['phone_number']     = $customer['contact'];
					        $get_usersdata_data['company_name']     = $customer['company_name'];
					        $get_usersdata_data['image']            = $customer['image'] != '' ? url('uploads/users', $customer['image']) : asset('frontassets/image/placeholder.jpg');
	            		}

	            		if ($get_usersdata_data) {
					  		$data[] = $get_usersdata_data;
	            		}
	            	}
	                  
	                $output['status']  = true;
	                $output['data']    = $data;
	                $output['message'] = 'My request';
	        	} else {
					$output['message'] = '401';
				} 
	        } else {
				$output['message'] = '401';
			}    
        }else{
            $output['message'] = '405';
        }
        return response()->json($output); die;
    }

}  