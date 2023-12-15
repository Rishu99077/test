<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Models\UserModel;
use App\Models\IconsModel;

class IconsController extends Controller
{

    public function icons(){
    	$data = array();
    	$data['main_menu'] = 'Setting';
    	$user_id = Session::get('user_id');
    	$data['user_details'] = UserModel::where(['id' => $user_id])->first();
    	

    	$get_icons = IconsModel::where(['User_ID' => $user_id])->orderBy('IconID', 'desc')->get();

    	$icons = array();
        foreach ($get_icons as $key => $value) {
          	$icon['IconID'] = $value['IconID'];
            $icon['icon_name'] = $value['icon_name'];
            $icon['image'] = $value['image'];
            $icon['status'] = $value['status'];
            $icon['restaurant_name'] = '';
            $single_user_details = UserModel::where(['id' => $value['User_ID']])->first();
            if (!empty($single_user_details)) {
               $icon['restaurant_name'] = $single_user_details['restaurant_name'];
            }


            $icons[] = $icon;
        }
    	return view('admin.Icons.index',compact('data','icons'));
    }

    
    public function add_icons(){  
   	  $data = array();
    	$data['main_menu'] = 'Icons'; 
    	$user_id = Session::get('user_id');
    	$data['user_details'] = UserModel::where(['id' => $user_id])->first();
    	

        $icons = array();
        $icons['icon_name']  = '';
        $icons['image']  = '';
        $icons['status'] = '';

        if(@$_GET['IconID'] != ''){
            $IconID = $_GET['IconID'];
             $get_icon = IconsModel::where(['IconID'=>$IconID])->first();
             $icons['IconID'] = $get_icon['IconID'];
             $icons['icon_name'] = $get_icon['icon_name'];  
             $icons['image'] = $get_icon['image'];        
             $icons['status'] = $get_icon['status'];
        }
       
        return view('admin.Icons.add_icon',compact('icons','data'));       
    }


    public function save_icons(Request $request){
        $user_id = Session::get('user_id');
        $user_details = UserModel::where(['id' => $user_id])->first();

        
        $IconID = $request->IconID;

        $data = $request->all();

          if ($IconID!='') {
              $get_icon = IconsModel::where('IconID','!=',$IconID)->where('User_ID',$user_id)->where('icon_name',$data['icon_name'])->first();
              if($get_icon){
                $error['icon_name'] = "The icon name is already taken";
                return response()->json(array('error' => $error));
              }


              $get_icon = IconsModel::where(['IconID' => $IconID])->first();
              $IconID = $get_icon['IconID'];

                $UpdateData = array();
                $UpdateData['icon_name'] = $data['icon_name'];
                $UpdateData['status'] = $data['status'];
                $x = 1 ;
                $data["image"] = '';
                if ($request->hasFile('image')) {
                   $img = $request->file('image');
                   $UpdateData["image"] = time().'_'.$x.'.'.$img->getClientOriginalExtension();
                   $destinationPath = public_path('/App/IconsImages');
                   $img->move($destinationPath, $UpdateData["image"]);
                   $x++;
                }   

                IconsModel::where(['IconID' => $IconID])->update($UpdateData);
          		$request->session()->flash('success', 'Icon Updated successfully!');           

          }else{
              $input = $request->all();
              $rules = [];
              $rules['icon_name'] = 'required';
              $required_msg = "The :attribute field is required.";

              $custom_msg = [];
              $custom_msg['required'] = $required_msg;

              $validator = Validator::make($input, $rules, $custom_msg);

              if ($validator->fails()) {
                  return response()->json(array('error'=>$validator->getMessageBag()->toArray(),));
              }

              $get_icon_add = IconsModel::where('User_ID',$user_id)->where('icon_name',$data['icon_name'])->first();
              if($get_icon_add){
                $error['icon_name'] = "The Icon name is already taken";
                return response()->json(array('error' => $error));
              }

              $Data = array();
              $Data['icon_name'] = $data['icon_name'];
            	$x = 1 ;
              $data["image"] = '';
              if ($request->hasFile('image')) {
                 $img = $request->file('image');
                 $Data["image"] = time().'_'.$x.'.'.$img->getClientOriginalExtension();
                 $destinationPath = public_path('/App/IconsImages');
                 $img->move($destinationPath, $Data["image"]);
                 $x++;
              }   
              if ($user_id=='1') {
                $Data['status'] = '1';
                $Data['superadmin_id'] = $user_id;
              }else{
                $Data['status'] = '0';
                $Data['admin_id'] = $user_id;
              }
              $Data['User_ID']  = $user_id;
              $insert_id = IconsModel::create($Data);
            	$request->session()->flash('success', 'Icon added successfully!');           
          }   
    }


    public function delete_icons(Request $request){
      if($_GET['IconID'] != ''){
         $IconID = $_GET['IconID'];
          
         IconsModel::where('IconID', $IconID)->delete();

         $request->session()->flash('danger', 'Icon deleted successfully!');
         return redirect('icons');  
      }
    }

}
