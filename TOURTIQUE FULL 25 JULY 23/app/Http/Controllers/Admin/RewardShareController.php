<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rewards;
use App\Models\RewardsLanguage;
use App\Models\Language;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\View;
use Image;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RewardShareController extends Controller
{
    public function index(){
        $common          = array();
        $common['title'] = "Rewards Share";
        Session::put("TopMenu", "Rewards Share");
        Session::put("SubMenu", "Rewards Share");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $get_rewards = Rewards::select('rewards.*', 'rewards_language.title')
                        ->orderBy('rewards.id', 'desc')->where(['rewards.is_delete' => 0])
                        ->leftJoin("rewards_language", 'rewards.id', '=', 'rewards_language.reward_id')
                        ->groupBy('rewards.id')
                        ->paginate(config('adminconfig.records_per_page'));              

        return view('admin.Rewards.index', compact('common','get_rewards','lang_id'));
    }

    ///Add Rewards
    public function add_Reward(Request $request, $id = ""){
        $common = array();
        Session::put("TopMenu", "Rewards Share");
        Session::put("SubMenu", "Rewards Share");

        $get_session_language  = getSessionLang();
        $common['language_title'] = $get_session_language['title'];
        $common['language_flag']  = $get_session_language['flag_image'];
        $lang_id = $get_session_language['id'];

        $common['title']              = translate("Add Rewards");
        $common['button']             = translate("Save");
        $get_rewards                  = getTableColumn('rewards');
        $get_rewards_language = "";
        $languages             = Language::where(ConditionQuery())->get();

        if ($request->isMethod('post')) {

            $req_fields = array();
            $req_fields['name.*']   = "required";

            $errormsg = [
                "name.*" => translate("Title"),
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


            if ($request->id != "") {
                $message  = translate("Update Successfully");
                $status   = "success";
                $Rewards = Rewards::find($request->id);
                RewardsLanguage::where("reward_id", $request->id)->where('language_id',$lang_id)->delete();
            } else {
                $message  = translate("Add Successfully");
                $status   = "success";
                $Rewards = new Rewards();
            }

            $Product['status']         = isset($request->status) ? 'Active' : 'Deactive';
            $Rewards['share_points']  = $request->share_points;
            $Rewards['instagram']     = isset($request->instagram) ? 1 : 0;
            $Rewards['facebook']      = isset($request->facebook) ? 1 : 0;
            $Rewards['twitter']       = isset($request->twitter) ? 1 : 0;
            $Rewards['youtube']       = isset($request->youtube) ? 1 : 0;


            if ($request->hasFile('image')) {
                $files = $request->file('image');
                $random_no = Str::random(5);
                $newImage = time() . $random_no . '.' . $files->getClientOriginalExtension();
                $destinationPath = public_path('uploads/product_images');
                $imgFile = Image::make($files->path());
                $height = $imgFile->height();
                $width = $imgFile->width();
                if ($width > 600) {
                    $imgFile->resize(792, 450, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                if ($height > 600) {
                    $imgFile->resize(792, 450, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $destinationPath = public_path('uploads/product_images');
                $imgFile->save($destinationPath . '/' . $newImage);
                $Rewards['image'] = $newImage;
            }


            $Rewards->save();

            $get_languages = Language::where(['status'=>'Active','is_delete'=>0])->get();

            if (!empty($get_languages)) {
                foreach ($get_languages as $key => $value) {
                    if (!getDataFromDB('rewards_language',['language_id'=>$value['id'],'reward_id'=>$request->id],'row')) {
                    
                        $RewardsLanguage              = new RewardsLanguage();
                        
                        $RewardsLanguage->title         = isset($request->title[$value['id']]) ?  $request->title[$value['id']] : $request->title[$lang_id];
                        $RewardsLanguage->language_id   = $value['id'];
                        $RewardsLanguage->reward_id     = $Rewards->id;

                        $RewardsLanguage->save();
                    }
                    
                }
            }



            return redirect()->route('admin.rewardshare')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id           = checkDecrypt($id);
            $common['title']      = "Edit Reward";
            $common['button']     = "Update";
            $get_rewards = Rewards::where('id', $id)->first();
            $get_rewards_language = RewardsLanguage::where("reward_id", $id)->get()->toArray();

            if (!$get_rewards) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.Rewards.addReward', compact('common', 'get_rewards','languages', 'get_rewards_language','lang_id'));
    }
    
    public function delete($id){
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';

        $get_rewards =  Rewards::find($id);
        if ($get_rewards) {
            $get_rewards->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }
}
