<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App\Models\IconsModel;

class IconsApiController extends Controller
{

	  public function add(Request $request){
		
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [
                  'icon_name' => 'required',
                  'image' => 'required',
                  'user_id' => 'required',
              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }
			
  			$get_icon = IconsModel::where('User_ID',$request->user_id)->where('icon_name',$request->icon_name)->first();
  			if ($get_icon!='') {
  			  return response()->json([
  			        'status' => false,
  			        'message' => 'This icon name is already taken',
  			  ], 402);
  			}	

	        $data = array();
	        $data['icon_name'] = $request->icon_name; 

            $x = 1 ;
              $data["image"] = '';
              if ($request->hasFile('image')) {
                 $img = $request->file('image');
                 $data["image"] = time().'_'.$x.'.'.$img->getClientOriginalExtension();
                 $destinationPath = public_path('/App/IconsImages');
                 $img->move($destinationPath, $data["image"]);
                 $x++;
              }   

	          $data['User_ID'] = $request->user_id;	
            if ($request->user_id == '1') {
              $data['superadmin_id'] = $request->user_id; 
	            $data['status'] = 1;
            }else{
              $data['admin_id'] = $request->user_id;
              $data['status'] = 0; 
            }
	          $data['source'] = 'App'; 

	      	  $insert_id = IconsModel::create($data);
	           
            $res_data = array();
            $res_data['icon_id'] = $insert_id['id'];
            $res_data['icon_name'] = $request->icon_name;
            $IconImage = $data['image'];
            $res_data['image'] = url('/App/IconsImages/'.$IconImage);
           

	          return response()->json([
	            'status' => true,
	            'message' =>'Icon added successfully',
	            'data' => $res_data,
	          ], 402);
        }else{
          $output['message'] = '405';
        } 
       	echo json_encode($output);
       	die;   
  	
    }

    public function detail(Request $request){
    
        $output=array();
        $output['status']=false;
        if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

            $validator = Validator::make(
              $request->all(), 
              [
                  'icon_id' => 'required',
                  'user_id' => 'required',
              ]
            );

            if ($validator->fails()) {
                return response()->json([
                  'status' => false,
                  'message' => $validator->errors()->first(),
                ], 402);
            }

            $get_single_icon = IconsModel::where(['IconID' => $request->icon_id , 'User_ID' => $request->user_id])->first();
            
            if ($get_single_icon) {
              $data = array();
              $data['icon_id'] = $get_single_icon->IconID;
              $data['icon_name'] = '';
              if ($get_single_icon->icon_name) {
                $data['icon_name'] = $get_single_icon->icon_name;   
              } 
              $data['image'] = '';
              if ($get_single_icon->image) {
                $IconImage = $get_single_icon->image;
                $data['image'] = url('/App/IconsImages/'.$IconImage);   
              } 
            }else{
                return response()->json([
                  'status' => false,
                  'message' => 'This Icon is not exist for this user',
                ], 402);
            }
           
         
            return response()->json([
              'status' => true,
              'message' =>'Icon detail',
              'data' => $data,
            ], 402);
        }else{
          $output['message'] = '405';
        } 
       echo json_encode($output);
       die;   
    
    }

    public function update(Request $request){
      	$output=array();
      	$output['status']=false;
		if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

			$validator = Validator::make(
			$request->all(), 
				[
				    'icon_id' => 'required',
				    'icon_name' => 'required',
				    'image'=>'required',
				    'user_id' => 'required',
				]
			);

			if ($validator->fails()) {
			  return response()->json([
			    'status' => false,
			    'message' => $validator->errors()->first(),
			  ], 402);
			}

			$get_icon = IconsModel::where('IconID','!=',$request->icon_id)->where('User_ID',$request->user_id)->where('icon_name',$request->icon_name)->first();
			if ($get_icon!='') {
			  return response()->json([
			        'status' => false,
			        'message' => 'This icon name is already taken',
			  ], 402);
			}

	        $get_single_location = IconsModel::where(['User_ID' => $request->user_id,'IconID' => $request->icon_id])->first();
	        
	        if($get_single_location!=''){
	              $data = array();
	              $data['IconID'] = $get_single_location['IconID'];
	              $data['icon_name'] = $request->icon_name;

	              $x = 1 ;
	              $data["image"] = '';
	              if ($request->hasFile('image')) {
	                 $img = $request->file('image');
	                 $data["image"] = time().'_'.$x.'.'.$img->getClientOriginalExtension();
	                 $destinationPath = public_path('/App/IconsImages');
	                 $img->move($destinationPath, $data["image"]);
	                 $x++;
	              }   

	              $data['User_ID'] = $get_single_location['User_ID'];
	             
	              IconsModel::where('IconID', $get_single_location['IconID'])->update($data);
	               
	              $res_data = array();
	              $res_data['icon_id'] = $data['IconID'];
	              $res_data['icon_name'] = $data['icon_name'];
	              $IconImage = $data['image'];
	              $res_data['image'] = url('/App/IconsImages/'.$IconImage);  

	              return response()->json([
	                'status' => true,
	                'message' => 'Icon updated succesfully',
	                'data' => $res_data,
	              ], 402);

	        }else{
	             return response()->json([
	              'status' => false,
	              'message' => 'This Icon is not exist for this user',
	            ], 402);
	        } 
      	}else{
        	$output['message'] = '405';
      	} 
      	echo json_encode($output);
      	die;
    }


    public function icons_list(Request $request){
      $output=array();
      $output['status']=false;
      if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

          $validator = Validator::make(
            $request->all(), 
             [
                'user_id' => 'required',
            ]
          );

          if ($validator->fails()) {
              return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
              ], 402);
          }

          $data = array();
          $get_icons = IconsModel::where(['User_ID' => $request->user_id])->first();
          if ($get_icons) {
        
          $get_icons = IconsModel::where(['User_ID' => $request->user_id])->get();

            $icons = array();
            foreach ($get_icons as $key => $value) {
              $icon = array();
              $icon['icon_id'] = $value['IconID']; 
              $IconImage = $value['image'];
              $icon['icon_image'] = url('/App/IconsImages/'.$IconImage);
              $icon['icon_name'] = $value['icon_name'];
              $icon['user_id'] = $value['User_ID'];
              $icon['status'] = $value['status']; 
              $icons[] = $icon;
            }

            // $data['icons'] = $icons;          
           
            return response()->json([
              'status' => true,
              'message' => 'Icons list',
              'data' => $icons,
            ], 402);
          }else{
              return response()->json([
                'status' => false,
                'message' => 'No icons',
              ], 402);
          }  

      }else{
        $output['message'] = '405';
      } 
      echo json_encode($output);
      die;   

    }

    public function icon_delete(Request $request){
      $output=array();
      $output['status']=false;
      if((!empty($request->input('access_token'))) && file_get_contents(url('/').'/token_resource.php?access_token='.$request->input('access_token'))){

          $validator = Validator::make(
            $request->all(), 
            [
                'icon_id' => 'required',
                'user_id' => 'required',
            ]
          );

          if ($validator->fails()) {
              return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
              ], 402);
          }

          $get_icon = IconsModel::where(['User_ID' => $request->user_id,'IconID' => $request->icon_id])->first();
       
          if ($get_icon) {
             
              IconsModel::where(['User_ID' => $request->user_id,'IconID' => $request->icon_id])->delete();
             
              return response()->json([
                'status' => true,
                'message' => 'Icon deleted sucessfully',
              ], 402);
          }else{
              return response()->json([
                'status' => false,
                'message' => 'No Icon for this user',
              ], 402);
          }
          

      }else{
        $output['message'] = '405';
      } 
      echo json_encode($output);
      die;   

    }
}