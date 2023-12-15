<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\AddOn;
use App\Models\AddOnDescription;
use App\Models\Languages;
use Illuminate\Support\Str;

class AddOnController extends Controller
{
    public function index(Request $request)
    {
        $common = [];
        $common['title'] = 'Add-On';
        Session::put('TopMenu', translate('Products'));
        Session::put('SubMenu', translate('Add-On'));

        $get_session_language = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_add_on = AddOn::orderBy('id', 'desc')
            ->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $AddOn = [];
        if (!empty($get_add_on)) {
            foreach ($get_add_on as $key => $value) {
                $row = getLanguageData('add_on_description', $language_id, $value['id'], 'add_on_id');
                $row['id'] = $value['id'];
                $row['status'] = $value['status'];
                $AddOn[] = $row;
            }
        }

        return view('admin.add_on.index', compact('common', 'get_add_on', 'AddOn'));
    }

    // Add Add On

    public function add_addOn(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', translate('Products'));
        Session::put('SubMenu', translate('Add-On'));

        $common['title'] = translate('Add-On');
        $common['heading_title'] = translate('Add Add-On');
        $common['button'] = translate('Save');

        $get_add_on = getTableColumn('add_on');
        $get_add_on_language = getTableColumn('add_on_description');

        $get_session_language = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        if ($request->isMethod('post')) {
            $req_fields = [];
            $req_fields['title'] = 'required';

            $errormsg = [
                'title' => translate('Title'),
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

            $request->request->add(['user_id' => Session::get('admin_id')]);

            if ($request->id != '') {
                $message = translate('Update Successfully');
                $status = 'success';
                $AddOn = AddOn::find($request->id);
            } else {
                $message = translate('Add Successfully');
                $status = 'success';
                $AddOn = new AddOn();
            }

            $AddOn->status = $request->status;

            $AddOn->save();

            AddOnDescription::where(['add_on_id' => $AddOn->id, 'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $AddOnDescription = new AddOnDescription();
                $AddOnDescription->title = $request->title;
                $AddOnDescription->language_id = $language_id;
                $AddOnDescription->add_on_id = $AddOn->id;
                $AddOnDescription->save();
            }
            return redirect()
                ->route('admin.add_on')
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id = checkDecrypt($id);
            $common['title'] = translate('Edit Add-On');
            $common['heading_title'] = translate('Edit Add-On');
            $common['button'] = translate('Update');

            $get_add_on = AddOn::where('id', $id)->first();
            $get_add_on_language = getLanguageData('add_on_description', $language_id, $id, 'add_on_id');
            if (!$get_add_on) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        }
        return view('admin.add_on.add', compact('common', 'get_add_on', 'get_add_on_language'));
    }

    // Delete Add On
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'No Record Found']);
        }
        $id = checkDecrypt($id);
        $status = 'error';
        $message = 'Something went wrong!';
        $get_add_on = AddOn::where(['id' => $id])->first();
        if ($get_add_on) {
            $get_add_on->is_delete = 1;
            $get_add_on->save();
        }
        $status = 'success';
        $message = 'Delete Successfully';
        return back()->withErrors([$status => $message]);
    }
}
