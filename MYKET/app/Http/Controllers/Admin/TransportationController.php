<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Transportation;

use App\Models\Product;
use App\Models\ProductImages;
use App\Models\ProductOption;
use App\Models\ProductInformation;
use App\Models\ProductLocation;

use App\Models\ProductOptionPricing;
use App\Models\ProductOptionPricingTiers;
use App\Models\ProductOptionAddOn;
use App\Models\ProductOptionAddOnTiers;
use App\Models\ProductOptionPricingDetails;

use App\Models\ProductDescription;
use App\Models\ProductInformationDescription;
use App\Models\ProductOptionPricingDescription;
use App\Models\ProductOptionAvailability;
use App\Models\ProductOptionAvailabilityDescription;
use App\Models\ProductOptionDiscount;

use App\Models\ProductInclusion;
use App\Models\ProductHighlight;
use App\Models\ProductHighlightDescription;
use App\Models\ProductRestriction;
use App\Models\ProductAboutActivity;
use App\Models\ProductAboutActivityDescription;
use App\Models\ProductTransportation;
use App\Models\ProductFoodDrink;




use App\Models\TransportationDescription;
use App\Models\Languages;
use Illuminate\Support\Str;

class TransportationController extends Controller
{
    public function index(Request $request)
    {
        $common          = array();
        $common['title'] = "Transportation";
        Session::put("TopMenu", "Products");
        Session::put("SubMenu", "Transportation");

        $get_session_language     = getLang();
        $common['language_title'] = $get_session_language['title'];
        $language_id = $get_session_language['id'];

        $get_transportation = Transportation::orderBy('id', 'desc')->whereNull('is_delete')
            ->paginate(config('adminconfig.records_per_page'));

        $Transportation = [];
        if (!empty($get_transportation)) {
            foreach ($get_transportation as $key => $value) {
                $row  = getLanguageData('transportation_description', $language_id, $value['id'], 'transportation_id');
                $row['id']               = $value['id'];
                $row['status']           = $value['status'];
                $row['capacity']         = $value['capacity'];
                $row['air_conditioning'] = $value['air_conditioning'];
                $row['wifi']             = $value['wifi'];
                $row['private_shared']   = $value['private_shared'];
                $Transportation[] = $row;
            }
        }

        return view('admin.transportation.index', compact('common', 'get_transportation', 'Transportation'));
    }

    // Add Transportation
    public function add_transportation(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Products");
        Session::put("SubMenu", "Transportation");

        $common['title']          = 'Transportation';
        $common['heading_title']  = 'Add Transportation';

        $common['button']            = translate("Save");
        $get_transportation           = getTableColumn('transportation');
        $get_transportation_language  = getTableColumn('transportation_description');

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
                $Transportation     = Transportation::find($request->id);
            } else {
                $message   = translate("Add Successfully");
                $status    = "success";
                $Transportation      = new Transportation();
            }

            $Transportation->status = $request->status;
            if ($request->capacity_tab) {
                $Transportation->capacity  = 'yes';
            } else {
                $Transportation->capacity  = 'no';
            }
            if ($request->air_conditioning_tab) {
                $Transportation->air_conditioning  = 'yes';
            } else {
                $Transportation->air_conditioning  = 'no';
            }
            if ($request->wifi_tab) {
                $Transportation->wifi  = 'yes';
            } else {
                $Transportation->wifi  = 'no';
            }
            if ($request->private_shared_tab) {
                $Transportation->private_shared  = 'yes';
            } else {
                $Transportation->private_shared  = 'no';
            }
            $Transportation->save();

            TransportationDescription::where(["transportation_id" => $Transportation->id, 'language_id' => $language_id])->delete();
            if (isset($request->title)) {
                $TransportationDescription                = new TransportationDescription();
                $TransportationDescription->title         = $request->title;
                $TransportationDescription->language_id   = $language_id;
                $TransportationDescription->transportation_id  = $Transportation->id;
                $TransportationDescription->save();
            }
            return redirect()->route('admin.transportation')->withErrors([$status => $message]);
        }

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id                         = checkDecrypt($id);
            $common['title']            = "Edit Transportation";
            $common['heading_title']    = "Edit Transportation";
            $common['button']           = "Update";

            $get_transportation = Transportation::where('id', $id)->first();
            $get_transportation_language  = getLanguageData('transportation_description', $language_id, $id, 'transportation_id');

            if (!$get_transportation) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.transportation.addtransportation', compact('common', 'get_transportation', 'get_transportation_language'));
    }

    // Delete Transportation
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status       = 'error';
        $message      = 'Something went wrong!';
        $get_transportation =  Transportation::where(['id' => $id])->first();
        if ($get_transportation) {
            $get_transportation->is_delete = 1;
            $get_transportation->save();
        }
        $status  = 'success';
        $message = 'Delete Successfully';
        return back()->withErrors([$status => $message]);
    }

    public function product_delete(Request $request, $id = "")
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status       = 'error';
        $message      = 'Something went wrong!';


        $get_product =  Product::where(['id' => $id])->whereNull('is_delete')->first();
        if ($get_product) {
            $get_product->is_delete = 1;
            $get_product->save();
            ProductDescription::where(['product_id' => $id])->delete();
            ProductLocation::where(['product_id' => $id])->delete();

            ProductInclusion::where(['product_id' => $id])->delete();
            ProductHighlight::where(['product_id' => $id])->delete();
            ProductRestriction::where(['product_id' => $id])->delete();
            ProductAboutActivity::where(['product_id' => $id])->delete();
            ProductTransportation::where(['product_id' => $id])->delete();
            ProductFoodDrink::where(['product_id' => $id])->delete();

            ProductInformation::where(['product_id' => $id])->delete();
            ProductImages::where(['product_id' => $id])->delete();
            ProductOption::where(['product_id' => $id])->delete();
            ProductOptionPricing::where(['product_id' => $id])->delete();
            ProductOptionPricingDetails::where(['product_id' => $id])->delete();
            ProductOptionPricingTiers::where(['product_id' => $id])->delete();
            ProductOptionAddOn::where(['product_id' => $id])->delete();
            ProductOptionAddOnTiers::where(['product_id' => $id])->delete();
            ProductOptionPricingDescription::where(['product_id' => $id])->delete();
            ProductOptionAvailability::where(['product_id' => $id])->delete();
            ProductOptionAvailabilityDescription::where(['product_id' => $id])->delete();
            ProductOptionDiscount::where(['product_id' => $id])->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }

        return back()->withErrors([$status => $message]);
    }
}
