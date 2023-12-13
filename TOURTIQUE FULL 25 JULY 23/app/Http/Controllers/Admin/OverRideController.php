<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OverRide;

use App\Models\OverRideBanner;
use App\Models\OverRideBannerLanguage;
use App\Models\Language;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use App\Models\Country;

class OverRideController extends Controller
{
    ///Add Over Ride Banner
    public function addBanner(Request $request, $id = '')
    {
        $common = [];
        Session::put('TopMenu', 'Settings');
        Session::put('SubMenu', 'Over Ride Banner');

        $common['title'] = translate('Add Over Ride Banner');
        $common['button'] = translate('Save');

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $get_over_ride = getTableColumn('over_ride');

        $languages = Language::where(ConditionQuery())->get();
        $country = Country::all();

        $get_over_ride_banner = [];
        $get_over_ride_banner_language = [];

        $EXO = getTableColumn('over_ride_banner');



        // echo "<pre>";
        // print_r($request->all());
        // echo "</pre>";die();

        if ($request->isMethod('post')) {
            $req_fields = [];
            $req_fields['title.*'] = 'required';

            $errormsg = [
                'title.*' => translate('Title'),
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
                $message = translate('Update Successfully');
                $status = 'success';
                $OverRide = OverRide::find($request->id);
            } else {
                $message = translate('Add Successfully');
                $status = 'success';
                $OverRide = new OverRide();
            }

            $OverRide['status'] = isset($request->status) ? 'Active' : 'Deactive';

            $OverRide->save();

            $over_ride_id = $OverRide->id;

            if ($request->banner_title) {
                // OverRideBanner::where(['over_ride_id' => $over_ride_id])->delete();
                OverRideBannerLanguage::where(['over_ride_id' => $over_ride_id,'language_id'=>$lang_id])->delete();

                foreach ($request->over_ride_banner_id as $key => $value_2) {
                    if ($value_2 != '') {
                        $OverRideBanner = OverRideBanner::find($value_2);
                    } else {
                        $OverRideBanner = new OverRideBanner();
                    }

                    if ($request->hasFile('banner_image')) {
                        if (isset($request->banner_image[$key]) && $request->banner_image[$key] != '') {
                            $files = $request->file('banner_image')[$key];
                            $random_no = uniqid();
                            $img = $files;
                            $ext = $files->getClientOriginalExtension();
                            $new_name = $random_no . time() . '.' . $ext;
                            $destinationPath = public_path('uploads/our_team');
                            $img->move($destinationPath, $new_name);
                            $OverRideBanner['banner_image'] = $new_name;
                        }
                    }

                    $OverRideBanner['country'] = isset($request->country[$key]) ? implode(',', $request->country[$key]) : '';
                    $OverRideBanner['over_ride_id'] = $over_ride_id;
                    $OverRideBanner['link'] = $request->link[$key];
                    $OverRideBanner->save();

                    foreach ($request->banner_title as $VKey => $HL) {
                        if ($HL[$key] != '') {
                            $OverRideBannerLanguage = new OverRideBannerLanguage();
                            $OverRideBannerLanguage['over_ride_id'] = $over_ride_id;
                            $OverRideBannerLanguage['language_id'] = $VKey;
                            $OverRideBannerLanguage['over_ride_banner_id'] = $OverRideBanner->id;
                            $OverRideBannerLanguage['banner_title'] = $HL[$key];
                            $OverRideBannerLanguage['banner_description'] = change_str($request->banner_description[$VKey][$key]);
                            $OverRideBannerLanguage->save();
                        }
                    }
                }
            }

            return redirect()
                ->route('admin.override_banner.edit', encrypt(1))
                ->withErrors([$status => $message]);
        }

        if ($id != '') {
            if (checkDecrypt($id) == false) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'No Record Found']);
            }
            $id = checkDecrypt($id);
            $common['title'] = 'Edit City Guide List';
            $common['button'] = 'Update';

            $get_over_ride = OverRide::where('id', $id)->first();

            $get_over_ride_banner = OverRideBanner::where('over_ride_id', $id)->get();
            $get_over_ride_banner_language = OverRideBannerLanguage::where('over_ride_id', $id)->get();

            if (!$get_over_ride) {
                return back()->withErrors(['error' => 'Something went wrong']);
            }
        }
        return view('admin.over_ride_banner.addBanner', compact('common', 'get_over_ride', 'languages', 'get_over_ride_banner', 'get_over_ride_banner_language', 'EXO', 'country','lang_id'));
    }

    public function delete_single_banner(Request $request)
    {
        $Banner_id = $request->Banner_id;
        if ($Banner_id != '') {
            OverRideBanner::where('id', $Banner_id)->delete();

            OverRideBannerLanguage::where('over_ride_banner_id', $Banner_id)->delete();
        }
    }
}
