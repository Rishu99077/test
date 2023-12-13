<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffilliateCommission;
use App\Models\AffilliateCommissionHistory;

use App\Models\Customers;
use App\Models\User;
use App\Models\ProductCheckout;
use App\Models\Country;
use App\Models\States;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class CommissionController extends Controller
{
    // All Comission
    public function index()
    {
        $common = array();
        Session::put("TopMenu", "Affiliate");
        Session::put("SubMenu", "Commission");

        $common['title']      = translate("Commission");

        $product_checkout  = ProductCheckout::all();
        $get_affiliates     = User::where('user_type','Affiliate')->get();

        $Order    		  = @$_GET['Order'];
        $Affiliate  		  = @$_GET['Affiliate'];
        $Affilliate_code  = @$_GET['Affilliate_code'];

        $AffilliateCommission = AffilliateCommission::orderBy('id', 'desc');

        if (@$_GET['Order']) {
        	$AffilliateCommission = $AffilliateCommission->where('order_id',$Order);
        }

        if(@$_GET['Affilliate_code']){
           $AffilliateCommission = $AffilliateCommission->where('affilliate_code','LIKE', '%'.$Affilliate_code.'%');
        }   

        if (@$_GET['Affiliate']) {
        	$AffilliateCommission = $AffilliateCommission->where('user_id',$Affiliate);
        }

        $get_affiliate_commission = $AffilliateCommission->paginate(config('adminconfig.records_per_page'));

        $affiliate_comission = array();
        foreach ($get_affiliate_commission as $key => $value) {
        	$row = array();
        	$row['id'] 				= $value['id'];
        	$row['user_id'] 		= $value['user_id'];
        	$row['affiliate_name'] 	= '';
        	if ($value['user_id']) {
        		$get_customer  = User::where([ 'id' => $value['user_id']])->first();
        		if ($get_customer) {
        			$row['affiliate_name'] = $get_customer['name'];
        		}
        	}
        	$row['affilliate_code'] = $value['affilliate_code'];
        	$row['total'] 			= $value['total'];
        	$row['order_id'] 		= $value['order_id'];
            $row['product_order_id'] = '';
        	if ($value['order_id']) {
        		$get_product_checkout  = ProductCheckout::where([ 'id' => $value['order_id']])->first();
        		if ($get_product_checkout) {
        			$row['product_order_id'] = $get_product_checkout['order_id'];
        		}
        	}

            $get_comission_history = AffilliateCommissionHistory::where(['order_id' => $value['order_id'],'afilliate_comission_id' => $value['id']])->get();
            $total_paid_amount = 0;
            foreach ($get_comission_history as $key => $value_2) {
                $total_paid_amount += $value_2['paid_amount'];
            }
            $row['total_paid_amount']  = $total_paid_amount;
            $row['remaining_amount']   = $value['total'] - $total_paid_amount;

        	$affiliate_comission[] = $row;
        }


        return view('admin.Commission.index', compact('common', 'get_affiliate_commission','affiliate_comission','product_checkout','get_affiliates'));
    }

    public function commission_view(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Affiliate");
        Session::put("SubMenu", "Commission");

        $common['title']      = translate("View Commission");

        $get_affiliate_commission = getTableColumn('afilliate_comission');

        if ($id != "") {
            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id = checkDecrypt($id);
            $common['button']            = translate("Update");
            $get_affiliate_commission    = AffilliateCommission::where('id', $id)->first();
            $get_data = array();
            if ($get_affiliate_commission) {
            	$get_data['id'] 			= $get_affiliate_commission['id'];
	        	$get_data['user_id'] 		= $get_affiliate_commission['user_id'];
	        	$get_data['affiliate_name'] 	= '';
	        	if ($get_affiliate_commission['user_id']) {
	        		$get_customer  = User::where([ 'id' => $get_affiliate_commission['user_id']])->first();
	        		if ($get_customer) {
	        			$get_data['affiliate_name'] = $get_customer['name'];
	        		}
	        	}
	        	$get_data['affilliate_code'] = $get_affiliate_commission['affilliate_code'];
	        	$get_data['total'] 			 = $get_affiliate_commission['total'];
	        	$get_data['order_id'] 		 = $get_affiliate_commission['order_id'];
	        	$get_data['extra'] 		 	 = json_decode($get_affiliate_commission['extra']);
                $get_data['product_order_id'] = '';
	        	if ($get_affiliate_commission['order_id']) {
	        		$get_product_checkout  = ProductCheckout::where([ 'id' => $get_affiliate_commission['order_id']])->first();
	        		if ($get_product_checkout) {
	        			$get_data['product_order_id'] = $get_product_checkout['order_id'];
	        		}
	        	}

                $get_comission_history = AffilliateCommissionHistory::where(['order_id' => $get_affiliate_commission['order_id'],'afilliate_comission_id' => $get_affiliate_commission['id']])->get();

                $total_paid_amount = 0;
                foreach ($get_comission_history as $key => $value) {
                    $total_paid_amount += $value['paid_amount'];
                }

                $get_data['total_paid_amount']  = $total_paid_amount;
                $get_data['remaining_amount']   = $get_affiliate_commission['total'] - $total_paid_amount;


            }


            if (!$get_affiliate_commission) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.Commission.view', compact('common', 'get_affiliate_commission','get_data'));
    }

    public function add_comission_history(Request $request, $id = "")
    {
        
        if ($request->isMethod('post')) {

            $message  = translate("Add Successfully");
            $status   = "success";

            $AffilliateCommissionHistory = new AffilliateCommissionHistory();
          
            $AffilliateCommissionHistory['afilliate_comission_id']  = $request->afilliate_comission_id;
            $AffilliateCommissionHistory['order_id']                = $request->order_id;
            $AffilliateCommissionHistory['paid_amount']             = $request->paid_amount;
            $AffilliateCommissionHistory['user_id']                 = $request->user_id;

            $AffilliateCommissionHistory->save();

            $get_affiliate = AffilliateCommission::where(['id' => $request->afilliate_comission_id , 'order_id' => $request->order_id])->first();

            if ($get_affiliate) {
                $get_comission_history = AffilliateCommissionHistory::where(['order_id' => $get_affiliate['order_id'],'afilliate_comission_id' => $get_affiliate['id']])->get();

                $total_paid_amount = 0;
                foreach ($get_comission_history as $key => $value) {
                    $total_paid_amount += $value['paid_amount'];
                }

                if ($total_paid_amount == $get_affiliate['total']) {
                    $updateData = array();
                    $updateData['status'] = 'Paid';
                    AffilliateCommission::where(['id' => $request->afilliate_comission_id])->update($updateData);   
                }
            }


            return redirect()->route('admin.commission')->withErrors([$status => $message]);
        }
    }

}
