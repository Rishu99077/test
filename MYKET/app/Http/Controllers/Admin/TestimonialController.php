<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Testimonials;
use App\Models\Testimonialdescriptions;
use App\Models\Languages;
use Illuminate\Support\Str;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = "Testimonial";
        Session::put("TopMenu", "Page Building");
        Session::put("SubMenu", "Testimonials");

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_testimonial = Testimonials::orderBy('id', 'desc')->whereNull('is_delete')
        ->paginate(config('adminconfig.records_per_page'));

        $Testomonials = array();
        if (!empty($get_testimonial)) {
            foreach ($get_testimonial as $key => $value) {
                $row  = getLanguageData('testimonial_descriptions', $language_id, $value['id'], 'testimonial_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $row['image']  = $value['image'];
                $Testomonials[] = $row;
            }
        }    

        return view('admin.testimonials.index', compact('common', 'get_testimonial', 'Testomonials'));
    }

    // Add Testimonials
    public function add_testimonials(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Page Building");
        Session::put("SubMenu", "Testimonials");

        $common['title']          = 'Testimonial';
        $common['heading_title']  = 'Add Testimonial';

        $common['button']         = translate("Save");
        $get_testimonial          = getTableColumn('testimonials');
        $get_testimonial_language = getTableColumn('testimonial_descriptions');
        
        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        if ($request->isMethod('post')) {

            $req_fields = array();
            if($request->id !=''){
                $req_fields['title']        = "required";
            }else{
                $req_fields['title']        = "required";
                $req_fields['image']        = "required|mimes:jpeg,jpg,png,svg,gif";
                $req_fields['destination']  = "required";

            }
            $errormsg = [
                "title" => translate("Title"),
            ];

            $validation = Validator::make(
                $request->all(),
                $req_fields,
                [
                    'required' => 'The :attribute field is required.',
                ],
                $errormsg
            );

            if ($validation->fails()) {
                return back()->withErrors($validation)->withInput();
            }

            $request->request->add(['user_id' => Session::get('admin_id')]);

            if ($request->id != "") {
                $message      = translate("Update Successfully");
                $status       = "success";
                $Testomonials = Testimonials::find($request->id);
            } else {
                $message      = translate("Add Successfully");
                $status       = "success";
                $Testomonials = new Testimonials();
            }

            $Testomonials->status =$request->status;
            if ($request->hasFile('image')) {
                $random_no  = uniqid();
                $img        = $request->file('image');
                $mime_type  =  $img->getMimeType();
                $ext        = $img->getClientOriginalExtension();
                $new_name   = $random_no . '.' . $ext;
                $destinationPath =  public_path('uploads/testimonials');
                $img->move($destinationPath, $new_name);
                $Testomonials->image = $new_name;
            }
            $Testomonials->save();
            
            Testimonialdescriptions::where(["testimonial_id" => $Testomonials->id ,'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $Testimonialdescriptions                 = new Testimonialdescriptions();
                $Testimonialdescriptions->title          = $request->title;
                $Testimonialdescriptions->description    = $request->description;
                $Testimonialdescriptions->destination    = $request->destination;
                $Testimonialdescriptions->language_id  = $language_id;
                $Testimonialdescriptions->testimonial_id = $Testomonials->id;
                $Testimonialdescriptions->save();            
            }
            return redirect()->route('admin.testimonials')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = "Edit Testimonials";
            $common['heading_title']    = "Edit Testimonials";
            $common['button']           = "Update";
            $get_testimonial = Testimonials::where('id', $id)->first();
            $get_testimonial_language  = getLanguageData('testimonial_descriptions', $language_id, $id, 'testimonial_id'); 
            if (!$get_testimonial) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.testimonials.addtestimonial', compact('common', 'get_testimonial','get_testimonial_language'));
    }


    // Delete Testimonial
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_testimonial =  Testimonials::where(['id' => $id])->first();
        if ($get_testimonial) {
            $get_testimonial->is_delete = 1;
            $get_testimonial->save();
        }
        $status  = 'success';
        $message = 'Delete Successfully';
        return back()->withErrors([$status => $message]);
    }
}
