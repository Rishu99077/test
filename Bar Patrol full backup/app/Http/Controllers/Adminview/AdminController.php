<?php

namespace App\Http\Controllers\Adminview;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Models\UserModel;
use App\Models\CountriesModel;
use App\Models\StatesModel;
use App\Models\CitiesModel;

class AdminController extends Controller{
    

    public function Login(Request $request){

        $validation = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'required'
        ])->validate();
        $user = User::where(['email' => $request->email])->first();
      
        if(!empty($user)){
            if(sha1($request->password)==$user->password){
                
                $request->session()->put('user_id', $user->id);
                return redirect('dashboard');
               
            }else{
                return redirect()->back()->withErrors(['error'=> 'Invalid password']);
            }
        }else{
            return redirect()->back()->withErrors(['error'=> 'User not found']);
        }
    }

    public function dashboard(Request $request){
        $data = array();
        $data['main_menu'] = 'Dashboard';
    	$user_id = Session::get('user_id');
    	$data['user_details'] = UserModel::where(['id' => $user_id])->first()->toArray();
    	

    	return view('admin.dashboard',compact('data'));
    }

    public function Signup(){
        $get_countries = CountriesModel::all();
    	return view('signup',compact('get_countries'));
    }

    public function save_signup(Request $request){
        if($request->isMethod('post')){
            $validator = Validator::make(
              $request->all(), 
               [
                    'restaurant_name'=>'required|unique:users',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:6',
                    'confirm_password' => 'required|min:6|same:password',
                    'phone_no' => 'required|min:10|unique:users',
                    'country' => 'required',
                    'state' => 'required',
                    'city' => 'required',

               ]
            );

            if ($validator->fails()) {
                return response()->json(array('error'=>$validator->getMessageBag()->toArray(),));
            }

            $data                       = $request->all();
            $content                    = new UserModel;
            $content->email             = $data['email'];
            $content->phone_no      = $data['phone_no'];
            $content->restaurant_name      = $data['restaurant_name'];
            $content->password          = sha1($data['password']);
            $content->user_role   = 2;
            $content->country        = $data['country'];
            $content->state         = $data['state'];
            $content->city         = $data['city'];
            $content->source = 'Web';
           
            if($content->save()){
                return redirect('/admin_login')->with('success','Signup successfully');
            }
        }     
    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/admin_login');
    }


    public function get_states_by_countryid($CountryID)
    {
        $get_states = StatesModel::where('country_id',$CountryID)
                            ->get()
                            ->toArray();
        $response = [];
        $options =  '<option value="">Choose State</option>';
        if(!empty($get_states)){
            foreach ($get_states as $key => $value) {
                if($value['id'] == @$_GET['StateID']){
                    $options .=  "<option value=".$value['id']." selected='selected' >".ucfirst($value['name'])." </option> ";
                }else{
                    $options .=  "<option value=".$value['id']." >".ucfirst($value['name'])." </option> ";
                }
                //$options .=  "<option value=".$value['id']." >".ucfirst($value['name'])." </option> ";
                
            }
        }
        $response['get_states']   = $options;
        return $response;
    }

    public function get_cities_by_stateid($StateID)
    {
        
        $get_cities = CitiesModel::where('state_id',$StateID)
                            ->get()
                            ->toArray();
        $response = [];
        $options =  '<option value="">Choose City</option>';
        if(!empty($get_cities)){
            foreach ($get_cities as $key => $value) {
                if($value['id'] ==  @$_GET['CityID']){
                    $options .=  "<option value=".$value['id']." selected='selected' >".ucfirst($value['name'])." </option> ";
                }else{
                    $options .=  "<option value=".$value['id'].">".ucfirst($value['name'])." </option> ";
                }
                
                
            }
        }
        $response['get_cities']   = $options;
        return $response;
    }

}

