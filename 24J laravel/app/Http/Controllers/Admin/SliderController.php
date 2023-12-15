<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Users;
use App\Models\SliderImages;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;

use Image;
use Illuminate\Support\Str;


class SliderController extends Controller
{
	 // Slider
    public function index()
    {
        $common          = array();
        $common['title'] = "Slider";
        $common['heading_title'] = 'Slider';

        Session::put("TopMenu", "Slider");
        Session::put("SubMenu", "Slider");

        $get_slider = SliderImages::orderBy('id', 'asc')->whereNull('is_delete')->paginate(config('adminconfig.records_per_page'));

        return view('admin.Slider.index', compact('common', 'get_slider'));
    }

    ///Add Slider
    public function add_slider(Request $request, $id = '')
    {
        $common = [];
        $common['title'] = 'Add Slider';
        $common['heading_title'] = 'Slider';
        $common['button']       = 'Save';
        Session::put('TopMenu', 'Slider');
        Session::put('SubMenu', 'Slider');

        $get_slider =  array();

        $table = 'slider_images';
        $tableColumn = Schema::getColumnListing($table);
        foreach ($tableColumn as $TC) {
            $get_slider[$TC] = '';
        }
        
       
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
                $SliderImages = SliderImages::find($request->id);
            } else {
                $message = 'Add Successfully';
                $status = 'success';
                $SliderImages = new SliderImages();
            }

            $SliderImages['title']             = $request->title;
            $SliderImages['status']            = $request->status;

            if ($request->hasFile('image')) {
                $image                  = $request->file('image');
                $random_no              = Str::random(5);
                $newImage               = time() . $random_no . '.' . $image->getClientOriginalExtension();
                $destinationPath        = public_path('uploads/slider_images');
                $imgFile                = Image::make($image->path());
            
                $destinationPath = public_path('uploads/slider_images');
                $imgFile->save($destinationPath . '/' . $newImage);
                $SliderImages['image'] = $newImage;
            }

            $SliderImages->save();

            return redirect()
                ->route('admin.slider')
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
           
            $common['title'] = 'Edit Slider';
            $common['button'] = 'Update';

            $get_slider = SliderImages::where('id', $id)->first();

            if (!$get_slider) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        }
        return view('admin.Slider.add_slider', compact('common','get_slider'));
    }

    public function delete($id)
    {
        
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_slider =  SliderImages::find($id);
        if ($get_slider) {
            $get_slider->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }

}