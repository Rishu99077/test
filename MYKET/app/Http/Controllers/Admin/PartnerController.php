<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Partners;
use App\Models\Partnerdescriptions;
use App\Models\Languages;
use Illuminate\Support\Str;

class PartnerController extends Controller
{

    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = translate("Our Partners");
        Session::put("TopMenu", translate("Page Building"));
        Session::put("SubMenu", translate("Our Partners"));

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_partner = Partners::orderBy('id', 'desc')->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $partners = array();
        if (!empty($get_partner)) {
            foreach ($get_partner as $key => $value) {
                $row  = getLanguageData('partner_descriptions', $language_id, $value['id'], 'partner_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $row['image']  = $value['image'];
                $partners[] = $row;
            }
        }

        return view('admin.partners.index', compact('common', 'get_partner', 'partners'));
    }

    // Add Partners

    public function add_partners(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", translate("Page Building"));
        Session::put("SubMenu", translate("Our Partners"));

        $common['title']          = translate('Our Partners');
        $common['heading_title']  = translate('Add Our Partners');
        $common['button']         = translate("Save");

        $get_partner              = getTableColumn('partners');
        $get_partner_language     = getTableColumn('partner_descriptions');

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        if ($request->isMethod('post')) {

            $req_fields = array();
            if ($request->id != '') {
                $req_fields['title']   = "required";
            } else {
                $req_fields['title']   = "required";
                $req_fields['image']   = "required|mimes:jpg,jpeg,png,gif,svg";
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
                $message  = translate("Update Successfully");
                $status   = "success";
                $partners = Partners::find($request->id);
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $partners = new Partners();
            }

            $partners->status = $request->status;
            if ($request->hasFile('image')) {
                $random_no  = uniqid();
                $img        = $request->file('image');
                $mime_type  =  $img->getMimeType();
                $ext        = $img->getClientOriginalExtension();
                $new_name   = $random_no . '.' . $ext;
                $destinationPath =  public_path('uploads/partners');
                $img->move($destinationPath, $new_name);
                $partners->image = $new_name;
            }
            $partners->save();

            Partnerdescriptions::where(["partner_id" => $partners->id, 'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $Partnerdescriptions                = new Partnerdescriptions();
                $Partnerdescriptions->title         = $request->title;
                $Partnerdescriptions->language_id = $language_id;
                $Partnerdescriptions->partner_id    = $partners->id;
                $Partnerdescriptions->save();
            }
            return redirect()->route('admin.partners')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => translate("No Record Found")]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = translate("Edit Partners");
            $common['heading_title']    = translate("Edit Partners");
            $common['button']           = translate("Update");

            $get_partner = Partners::where('id', $id)->first();
            $get_partner_language  = getLanguageData('partner_descriptions', $language_id, $id, 'partner_id');
            if (!$get_partner) {
                return back()->withErrors(["error" => translate("Something went wrong")]);
            }
        }
        return view('admin.partners.addpartner', compact('common', 'get_partner', 'get_partner_language'));
    }


    // Delete Partners
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => translate("No Record Found")]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = translate('Something went wrong!');
        $get_partner =  Partners::where(['id' => $id])->first();
        if ($get_partner) {
            $get_partner->is_delete = 1;
            $get_partner->save();
        }
        $status     = 'success';
        $message    = translate('Delete Successfully');
        return back()->withErrors([$status => $message]);
    }
}
