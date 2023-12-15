<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Users;
use App\Models\Plans;
use App\Models\PlanFeature;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;

use Image;
use Illuminate\Support\Str;


class PlansController extends Controller
{
	 // Plans
    public function index()
    {
        $common          = array();
        $common['title'] = "Plans";
        $common['heading_title'] = 'Plans';

        Session::put("TopMenu", "Plans");
        Session::put("SubMenu", "Plans");

        $get_plan = Plans::orderBy('id', 'asc')->whereNull('is_delete')->paginate(config('adminconfig.records_per_page'));

        return view('admin.Plans.index', compact('common', 'get_plan'));
    }

    ///Add Plans
    public function add_plan(Request $request, $id = '')
    {
        $common = [];
        $common['title'] = 'Add Plans';
        $common['heading_title'] = 'Plans';
        $common['button']       = 'Save';
        Session::put('TopMenu', 'Plans');
        Session::put('SubMenu', 'Plans');

        $get_plan = getTableColumn('plans');

        $get_plan_features = [];
        $PFV = getTableColumn('plan_features');
        
        
        if ($request->isMethod('post')) {

            $req_fields          = [];
            $req_fields['title'] = 'required';
            if ($request->id == '') {
                $req_fields['image'] = 'required';
            }    
            $errormsg = [
                'title' => 'Title',
                'image' => 'image',
            ];

            $validation = Validator::make(
                $request->all(),
                $req_fields,
                [
                    'required' => 'The :attribute field is required.',
                ],
                $errormsg,
            );

            if ($validation->fails()) {
                return back()
                    ->withErrors($validation)
                    ->withInput();
            }

            if ($request->id != '') {
                $message   = 'Update Successfully';
                $status    = 'success';
                $Plans = Plans::find($request->id);
            } else {
                $message = 'Add Successfully';
                $status = 'success';
                $Plans = new Plans();
            }

            $Plans['title']             = $request->title;
            $Plans['price']             = $request->price;
            $Plans['duration']          = $request->duration;
            $Plans['description']       = $request->description;
            $Plans['status']            = $request->status;

            if ($request->hasFile('image')) {
                $image                  = $request->file('image');
                $random_no              = Str::random(5);
                $newImage               = time() . $random_no . '.' . $image->getClientOriginalExtension();
                $destinationPath        = public_path('uploads/plan_images');
                $imgFile                = Image::make($image->path());
            
                $destinationPath = public_path('uploads/plan_images');
                $imgFile->save($destinationPath . '/' . $newImage);
                $Plans['image'] = $newImage;
            }

            $Plans->save();

            if (!empty($request->feature_title)) {
                if ($request->feature_title) {
                    foreach ($request->features_id as $key => $over_value) {

                        if ($over_value != '') {
                            $PlanFeature       = PlanFeature::find($over_value);
                        } else {
                            $PlanFeature       = new PlanFeature();
                        }

                        $PlanFeature->plan_id        = $Plans->id;
                        $PlanFeature->feature_title  = $request->feature_title[$key];

                        $PlanFeature->save();
                    }
                }
            }

            return redirect()
                ->route('admin.plans')
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
           
            $common['title'] = 'Edit Plans';
            $common['button'] = 'Update';

            $get_plan = Plans::where('id', $id)->first();
            $get_plan_features  = PlanFeature::where('plan_id', $id)->get();

           

            if (!$get_plan) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        }
        return view('admin.Plans.add_plan', compact('common','get_plan','get_plan_features','PFV'));
    }

    public function delete($id)
    {
        
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_plan =  Plans::find($id);
        if ($get_plan) {
            $get_plan->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }

}