<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Language;

use App\Models\UserReview;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function index(){
        $common          = array();
        $common['title'] = "Reviews";
        Session::put("TopMenu", "Reviews");
        Session::put("SubMenu", "Reviews");

        $get_reviews = UserReview::orderBy('id', 'desc')->paginate(config('adminconfig.records_per_page'));
            
        return view('admin.Review.index', compact('common', 'get_reviews'));
    }


    public function reviewstatus(Request $request){

    	$output = array();
    	$output['status'] = false;
    	$output['message'] = "There is something went wrong.";
        if ($request->isMethod('post')) {
        	$id = checkDecrypt($request->id);

        	if ($id) {

        		$updatedta = [];
                $updatedta['status'] = $request->value;
                UserReview::where('id', $id)->update($updatedta);

        		$output['status'] = true;
    			$output['message'] = "Status Successfully updated.";
        	}
        }
        echo json_encode($output); die;
    }

}
