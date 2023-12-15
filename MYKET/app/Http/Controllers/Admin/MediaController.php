<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Media;
use App\Models\Mediadescriptions;
use App\Models\Languages;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = "Media";
        Session::put("TopMenu", translate("Products"));
        Session::put("SubMenu", translate("Media"));

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_media = Media::orderBy('id', 'desc')->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $Media = [];
        if (!empty($get_media)) {
            foreach ($get_media as $key => $value) {
                $row  = getLanguageData('media_descriptions', $language_id, $value['id'], 'media_id');
                $row['id']     = $value['id'];
                $row['status'] = $value['status'];
                $Media[] = $row;
            }
        }

        return view('admin.media.index', compact('common', 'get_media', 'Media'));
    }

    // Add Media

    public function add_media(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", translate("Products"));
        Session::put("SubMenu", translate("Media"));

        $common['title']          = translate('Media');
        $common['heading_title']  = translate('Add Media');

        $common['button']         = translate("Save");
        $get_media                = getTableColumn('medias');
        $get_media_language       = getTableColumn('media_descriptions');

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        if ($request->isMethod('post')) {

            $req_fields = array();
            $req_fields['title']   = "required";

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
                $message   = translate("Update Successfully");
                $status    = "success";
                $Media     = Media::find($request->id);
            } else {
                $message   = translate("Add Successfully");
                $status    = "success";
                $Media     = new Media();
            }

            $Media->status = $request->status;
            $Media->save();

            Mediadescriptions::where(["media_id" => $Media->id, 'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $Mediadescriptions                = new Mediadescriptions();
                $Mediadescriptions->title         = $request->title;
                $Mediadescriptions->language_id   = $language_id;
                $Mediadescriptions->media_id      = $Media->id;
                $Mediadescriptions->save();
            }
            return redirect()->route('admin.media')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => translate("No Record Found")]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = translate("Edit Media");
            $common['heading_title']    = translate("Edit Media");
            $common['button']           = translate("Update");

            $get_media = Media::where('id', $id)->first();
            $get_media_language  = getLanguageData('media_descriptions', $language_id, $id, 'media_id');

            if (!$get_media) {
                return back()->withErrors(["error" => translate("Something went wrong")]);
            }
        }
        return view('admin.media.addmedia', compact('common', 'get_media', 'get_media_language'));
    }


    // Delete Media

    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => translate("No Record Found")]);
        }
        $id = checkDecrypt($id);
        $status       = 'error';
        $message      = translate('Something went wrong!');
        $get_media =  Media::where(['id' => $id])->first();
        if ($get_media) {
            $get_media->is_delete = 1;
            $get_media->save();
        }
        $status  = 'success';
        $message = translate('Delete Successfully');
        return back()->withErrors([$status => $message]);
    }
}
