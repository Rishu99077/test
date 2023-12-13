<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Customers;
use App\Models\User;
use App\Models\Country;
use App\Models\AffilliateCommission;
use App\Models\ProductCheckout;
use DataTables;


class AffiliateController extends Controller
{
    // All Affiliate Profile
    public function index(Request $request)
    {
        $common = array();
        Session::put("TopMenu", "Affiliate");
        Session::put("SubMenu", "Add Affiliate");

        $common['title']  = translate("Affiliate");

        $get_affiliate = User::orderBy('id', 'desc')->where(['is_delete' => 0,'user_type' => 'Affiliate'])->get();

        if ($request->ajax()) {

            return Datatables::of($get_affiliate)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {

                    $btn = ' <a class="btn p-0" href="' . route("admin.affiliate.edit", encrypt($row["id"])) . '" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><span class="text-500 fas fa-edit"></span>
                    </a>

                    <a class="btn p-0 confirm-delete" data-href="' . route("admin.affiliate.delete", encrypt($row["id"])) . '"  href="javascript:void(0)" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><span class="text-500 fas fa-trash-alt"></span>
                    </a>

                    <a class="btn p-0" href="' . route("admin.affiliate.view", encrypt($row["id"])) . '" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="view"><span class="text-500 fas fa-eye"></span>
                    </a>';

                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    $status = checkStatus($row['status']);
                    return $status;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('admin.affiliate.index', compact('common', 'get_affiliate'));
    }

    public function store(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Affiliate");
        Session::put("SubMenu", "Add Affiliate");
        $common['title']      = translate("Add Affiliate");
        $common['button']     = translate("Save");
        $get_affiliate  = getTableColumn('users');
        $country      = Country::all();

        if ($request->isMethod('post')) {

            $req_fields        = array();
            $req_fields['name']        = "required";
            $req_fields['phone_number']         = "required";
            $req_fields['country']         = "required";
            $req_fields['state']           = "required";
            $req_fields['city']            = "required";

            if ($request->id == "") {
                $req_fields['email']         = "required|unique:users,email";
            } else {
                $req_fields['email']         = "required|unique:users,email," . $request->id;
            }



            $errormsg = [
                "name"            => translate("Full Name"),
                "phone_number"    => translate("Phone"),
                "email"           => translate("Email"),
                "country"         => translate("Country"),
                "state"           => translate("State"),
                "city"            => translate("City"),
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
                $message   = translate("Update Successfully");
                $status    = translate("success");
                $Customers = User::find($request->id);
            } else {
                $message   = translate("Add Successfully");
                $status    = translate("success");
                $Customers = new User();
            }

            if ($request->hasFile('image')) {
                $random_no       = uniqid();
                $img             = $request->file('image');
                $ext             = $img->getClientOriginalExtension();
                $new_name        = $random_no . '.' . $ext;
                $destinationPath = public_path('uploads/affiliate');
                $img->move($destinationPath, $new_name);
                $Customers['image']     = $new_name;
            }
            $Customers['name']          = $request->name;
            $Customers['email']         = $request->email;
            $Customers['phone_number']  = $request->phone_number;
            $Customers['country']       = $request->country;
            $Customers['city']          = $request->city;
            $Customers['state']                 = $request->state;
            $Customers['commission_percentage'] = $request->commission_percentage;
            $Customers['status']        = $request->status;
            $Customers['added_by']      = "admin";
            $Customers['user_type']     = "Affiliate";
            $Customers->save();

            return redirect()->route('admin.affiliate')->withErrors([$status => $message]);
        }

        if ($id != "") {

            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id = checkDecrypt($id);
            $common['title']             = translate("Edit Affiliate");
            $common['button']            = translate("Update");
            $get_affiliate  =  User::where('id', $id)->first();


            if (!$get_affiliate) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }
        return view('admin.affiliate.form', compact('common', 'get_affiliate', 'country'));
    }


    public function view(Request $request, $id = "")
    {
        $common = array();
        Session::put("TopMenu", "Affiliate");
        Session::put("SubMenu", "Add Affiliate");

        $common['title']      = translate("View Affiliate Profile");
       
        if ($id != "") {

            if (checkDecrypt($id) == false) {
                return redirect()->back()->withErrors(["error" => "No Record Found"]);
            }
            $id = checkDecrypt($id);
            $get_affiliate               = User::where('id', $id)->first();
            $get_affiliate_commission    = AffilliateCommission::where('user_id',$id)->orderBy('id','desc')->limit(4)->get();
            $get_affiliate_commission_count  = count($get_affiliate_commission);

            $affiliate_comission = array();
            $total_commision = 0;
            foreach ($get_affiliate_commission as $key => $value) {
                $row = array();
                $row['id']                = $value['id'];
                $row['user_id']           = $value['user_id'];
                $row['affilliate_code']   = $value['affilliate_code'];
                $row['total']             = $value['total'];
                $row['order_id']          = $value['order_id'];
                $row['created_at']        = $value['created_at'];

                $total_commision+= $value['total'];

                $row['affiliate_name']  = '';

                if ($value['user_id']) {
                    $get_customer  = User::where([ 'id' => $value['user_id']])->first();
                    if ($get_customer) {
                        $row['affiliate_name'] = $get_customer['name'];
                    }
                }
                $row['product_order_id'] = '';
                if ($value['order_id']) {
                    $get_product_checkout  = ProductCheckout::where([ 'id' => $value['order_id']])->first();
                    if ($get_product_checkout) {
                        $row['product_order_id'] = $get_product_checkout['order_id'];
                    }
                }

                $products_details             = json_decode($value['extra']);

                $row['extra'] = [];
                $total_commision_amount = 0;
                foreach ($products_details as $key2 => $value_2) {
                    $product = array();
                    $product['product_id']          =  $value_2->product_id;
                    $product['product_name']        =  $value_2->product_name;
                    $product['product_amount']      =  $value_2->product_amount;
                    $product['commission']          =  $value_2->commission;
                    $product['commission_amount']   =  $value_2->commission_amount;

                    $total_commision_amount+= $value_2->commission_amount;

                    $row['extra'][] = $product;
                }
           
                $row['total_commission_amount']   =  $total_commision_amount;

                $affiliate_comission[] = $row;
            }

            $total_affiliate_commission = $total_commision;
             

            if (!$get_affiliate) {
                return back()->withErrors(["error" => "Something went wrong"]);
            }
        }

        return view('admin.affiliate.view', compact('common','get_affiliate','get_affiliate_commission_count','affiliate_comission','total_affiliate_commission'));
    }

    // Deleete Afffilate
    public function delete($id)
    {
        if (checkDecrypt($id) == false) {
            return redirect()->back()->withErrors(["error" => "No Record Found"]);
        }
        $id = checkDecrypt($id);
        $status      = 'error';
        $message     = 'Something went wrong!';
        $Customers =  User::find($id);
        if ($Customers) {
            $Customers->delete();
            $status  = 'success';
            $message = 'Delete Successfully';
        }
        return back()->withErrors([$status => $message]);
    }
}
