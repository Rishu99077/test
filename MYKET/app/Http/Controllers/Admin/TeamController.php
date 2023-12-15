<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Teams;
use App\Models\Teamdescriptions;
use App\Models\Languages;
use Illuminate\Support\Str;

class TeamController extends Controller
{

    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = "Teams";
        Session::put("TopMenu", "Teams");
        Session::put("SubMenu", "Teams");

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_teams = Teams::orderBy('id', 'desc')->where(['status' => 'Active'])->whereNull('is_delete')
           ->paginate(config('adminconfig.records_per_page'));

        $Teams = array();
        if (!empty($get_teams)) {
            foreach ($get_teams as $key => $value) {
                $row  = getLanguageData('team_descriptions', $language_id, $value['id'], 'team_id');
                $row['id']            = $value['id'];
                $row['status']        = $value['status'];
                $row['image']         = $value['image'];
                $Teams[] = $row;
            }
        }    

        return view('admin.teams.index', compact('common', 'get_teams','Teams'));
    }


    // Add Teams
    public function add_teams(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Teams");
        Session::put("SubMenu", "Teams");

        $common['title']          = 'Teams';
        $common['heading_title']  = 'Add Teams';
        $common['button']         = translate("Save");
        $get_teams                = getTableColumn('teams');
        $get_team_language        = getTableColumn('team_descriptions');
        
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
                $message  = translate("Update Successfully");
                $status   = "success";
                $Teams    = Teams::find($request->id);
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $Teams    = new Teams();
            }

            $Teams->status =$request->status;
            if ($request->hasFile('image')) {
                $random_no  = uniqid();
                $img        = $request->file('image');
                $mime_type  =  $img->getMimeType();
                $ext        = $img->getClientOriginalExtension();
                $new_name   = $random_no . '.' . $ext;
                $destinationPath =  public_path('uploads/teams');
                $img->move($destinationPath, $new_name);
                $Teams->image = $new_name;
            }
            $Teams->save();

            Teamdescriptions::where(["team_id" => $Teams->id ,'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $Teamdescriptions                = new Teamdescriptions();
                $Teamdescriptions->title         = $request->title;
                $Teamdescriptions->designation   = $request->designation;
                $Teamdescriptions->language_id = $language_id;
                $Teamdescriptions->team_id       = $Teams->id;
                $Teamdescriptions->save();   
            }
            return redirect()->route('admin.teams')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id = checkDecrypt($id);
            $common['title']            = "Edit Teams";
            $common['heading_title']    = "Edit Teams";
            $common['button']           = "Update";
            
            $get_teams        = Teams::where('id', $id)->first();
            $get_team_language  = getLanguageData('team_descriptions', $language_id, $id, 'team_id');
            if (!$get_teams) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }

        return view('admin.teams.addteams', compact('common','get_teams','get_team_language'));
    }


    // Delete Teams
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $get_teams   =  Teams::where(['id' => $id])->whereNull('is_delete')->first();
        if ($get_teams) {
            $get_teams->is_delete = 1;
            $get_teams->save();
        }
        $status  = 'success';
        $message = 'Delete Successfully';
        return back()->withErrors([$status => $message]);
    }
}
