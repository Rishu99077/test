<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Languages;
use App\Models\Currency;
use App\Models\Countries;
use App\Models\ProductImages;
use App\Models\Categories;
use App\Models\Categorydescriptions;
use App\Models\Testimonials;
use App\Models\Testimonialdescriptions;
use App\Models\ProductType;
use App\Models\Product;
use App\Models\Partners;
use App\Models\States;
use App\Models\TopDestination;
use App\Models\Cities;
use App\Models\Faqs;
use App\Models\Faqdescriptions;
use App\Models\ContactUs;
use Illuminate\Support\Facades\Validator;
use Stichoza\GoogleTranslate\GoogleTranslate;

class HomeController extends Controller
{
    // Get Languages
    public function get_languages(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['msg'] = 'Not Data Found';
        $get_languages = [];

        $languages = Languages::where('status', 'Active')
            ->where('is_delete', null)
            ->get();
        if (!$languages->isEmpty()) {
            foreach ($languages as $key => $value) {
                # code...
                $get_language              = [];
                $get_language['id']        = $value['id'];
                $get_language['title']     = $value['title']     != '' ? $value['title'] : '';
                $get_language['id']        = $value['id']        != '' ? strtolower($value['id']) : 'en';
                $get_language['direction'] = $value['direction'] != '' ? $value['direction'] : '';
                $get_language['flag']      = $value['flag']      != '' ? asset('uploads/language_flag/' . $value['flag']) : asset('uploads/placeholder/placeholder.png');
                $get_languages[]           = $get_language;
            }

            $output['msg'] = 'Language List';
            $output['status'] = true;
        }
        $output['data'] = $get_languages;
        return json_encode($output);
    }

    // Get Currency
    public function get_currency(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['msg'] = 'Not Data Found';
        $get_currency = [];

        $Currency = Currency::where('status', 'Active')
            ->where('is_delete', null)
            ->get();
        if (!$Currency->isEmpty()) {
            foreach ($Currency as $key => $value) {
                # code...
                $get_currency_arr = [];
                $get_currency_arr['id'] = $value['id'];
                $get_currency_arr['title'] = $value['title'] != '' ? $value['title'] : '';
                $get_currency_arr['id'] = $value['id'] != '' ? $value['id'] : 'AED';
                $get_currency_arr['flag'] = $value['flag_image'] != '' ? asset('uploads/language_flag/' . $value['flag_image']) : asset('uploads/placeholder/placeholder.png');
                $get_currency[] = $get_currency_arr;
            }

            $output['msg'] = 'Currency List';
            $output['status'] = true;
        }
        $output['data'] = $get_currency;
        return json_encode($output);
    }

    // Set Languages
    public function set_language(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['msg'] = 'Not Data Found';
        $validation = Validator::make($request->all(), [
            'language' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }
        $get_language = [];
        if ($request->language == 'deafult') {
            $languages = Languages::where('is_default', 1)->first();
        } else {
            $languages = Languages::where('status', 'Active')
                ->where('is_delete', null)
                ->where('id', $request->language)
                ->first();
        }

        if ($languages) {
            $get_language['id']         = $languages['id'];

            $get_language['title']      = $languages['title']      != '' ? $languages['title'] : '';
            $get_language['short_code'] = $languages['id']  != '' ? strtolower($languages['id']) : 'en';
            $get_language['direction']  = $languages['direction']  != '' ? $languages['direction'] : '';
            $get_language['flag']       = $languages['flag'] != '' ? asset('uploads/language_flag/' . $languages['flag']) : asset('uploads/placeholder/placeholder.png');
            $output['msg']              = 'Language';
            $output['status']           = true;
        }

        $output['data'] = $get_language;
        return json_encode($output);
    }


    // Get State 
    public function get_states(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['msg'] = 'Not Data Found';
        $validation = Validator::make($request->all(), [
            'country' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }

        $States = States::where('country_id', $request->country)
            ->get();
        if (!$States->isEmpty()) {
            foreach ($States as $Ckey => $S) {
                $get_state_arr = [];
                $get_state_arr['id']    = $S['id'];
                $get_state_arr['label'] = $S['name'];
                $output['data'][] = $get_state_arr;
            }
            $output['status'] = true;
            $output['msg'] = "Data found successfully";
        }

        return json_encode($output);
    }

    // Get Cities 
    public function get_cities(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['msg'] = 'Not Data Found';
        $validation = Validator::make($request->all(), [
            'state' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }

        $Cities = Cities::where('state_id', $request->state)
            ->get();

        if (!$Cities->isEmpty()) {

            foreach ($Cities as $Ckey => $C) {
                $get_city_arr = [];
                $get_city_arr['id']    = $C['id'];
                $get_city_arr['label'] = $C['name'];
                $output['data'][] = $get_city_arr;
            }

            $output['status'] = true;
            $output['msg'] = "Data found successfully";
        }

        return json_encode($output);
    }

    public function search_data(Request $request)
    {
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'currency' => 'required',
            'term'     => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(
                [
                    'status'  => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }
        $term = $request->term;
        $language = $request->language;
        $data = [];
        if($term != ""){
                $translator = new GoogleTranslate();
                $translator->setSource(); // Detect language automatically
                // $tr;
                $translator->setTarget('en');

                // Translate the text
                $translatedText = $translator->translate($term);

                if($translator->getLastDetectedSource() != "en")
                {
                    $term = $translatedText;
                }
            }

        $Countries = Countries::where("name", 'like', '%' . $term . '%')->groupBy('name')->get();
        $States = States::where("name", 'like', '%' . $term . '%')->groupBy('name')->take(10)->get();
        $Cities = Cities::where("name", 'like', '%' . $term . '%')->groupBy('name')->take(20)->get();


        $keyProduct = Product::select('products.slug', 'products.id','products_description.title','products_description.keyword', 'products.cover_image')->where('products_description.keyword', 'like', "%{$term}%")->where(['status' => 'Active', 'is_delete' => null])->leftJoin('products_description', 'products_description.product_id', '=', 'products.id')->groupBy('products_description.keyword')->get();

   

        $Product = Product::select('products.slug', 'products.id', 'products_description.title', 'products.cover_image')->where('products_description.title', 'like', "%{$term}%")->where(['status' => 'Active', 'is_delete' => null])->leftJoin('products_description', 'products_description.product_id', '=', 'products.id')
        ->get();





        foreach ($Countries as $key => $C) {
            $row               = [];
            $row['image']      = "";
            $row['title']      = $C['name'];
            $row['slug']       = $C['name'];
            $row['type']       = 'country';
            $row['is_product'] = 0;
            $data[]            = $row;
        }

        foreach ($States as $key => $S) {
            $row          = [];
            $row['image'] = "";
            $row['title'] = $S['name'];
            $row['slug']  = $S['name'];
            $row['type']  = 'state';
            $row['is_product'] = 0;

            $data[]       = $row;
        }

        foreach ($Cities as $key => $C) {
            $row               = [];
            $row['image']      = "";
            $row['title']      = $C['name'];
            $row['slug']       = $C['name'];
            $row['type']       = 'city';
            $row['is_product'] = 0;

            $data[]       = $row;
        }
        $result= [];
        if(count($Product) > 0){
            $result  = $Product;
        }

        if(count($keyProduct) > 0){
            $result  = $keyProduct;
        }

        if(count($Product) > 0 && count($keyProduct) > 0){
        $result = (object) array_merge((array) $Product, (array) $keyProduct);}
       
        
        
        foreach ($result as $key => $P) {
          
            if(isset($P['id']))
            {
                $row               = [];
                $ProductImages = ProductImages::where(['product_id' => $P['id']])->first();
                $file = 'dummyproduct.png';
                if ($P['cover_image'] != "") {
                    $file = $P['cover_image'];
                } else {
                    if ($ProductImages) {
                        $file = $ProductImages->image;
                    }
                }
                $row['image']      = asset('uploads/products/' . $file);
                $row['title']      = $P['title'];
                $row['slug']       = $P['slug'];
                $row['is_product'] = 1;
                $data[]       = $row;
            }
        }
        
      




        if (!is_array($data)) {
            return $data;
        }
      
       
        usort($data, fn($a, $b) => levenshtein($term, $a['title']) <=> levenshtein($term, $b['title']));





        $output['data'] = $data;
        $output['status'] = true;
        $output['message'] = "Data found successfully";
        return json_encode($output);
    }

    // Contact Us 
    public function send_contact(Request $request){
        $output                = [];
        $output['status']      = false;
        $output['status_code'] = 402;
        $output['message']     = "Records not Found!";
        $output['data']        = "";
        $validation = Validator::make($request->all(), [
            'language' => 'required',
            'currency' => 'required',
            'name'     => 'required',
            'email'    => 'required',
            'message'  => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(
                [
                    'status'  => false,
                    'message' => $validation->errors()->first(),
                ],
                402,
            );
        }

        $language_id  = $request->language;
        $name  = $request->name;
        $email  = $request->email;
        $message  = $request->message;

        $ContactUs                  = new ContactUs();
        $ContactUs['name']          = $name;
        $ContactUs['email_address'] = $email;
        $ContactUs['message']       = $message;
        $ContactUs->save();

        $output['status'] = true;
        $output['message'] = "Message send successfully";
        return json_encode($output);
    }


    // Phone Code

    public function phone_code(Request $request)
    {
        $output = [];
        $output['status'] = false;
        $output['msg'] = 'Not Data Found';
       

       

        $data = [];
        $countries = Countries::where(['is_delete' => null])->get();
        foreach ($countries as $Ckey => $C) {

            if( file_exists(public_path()."/uploads/Flags/".$C['sortname'].".png")) 
            {
                $get_country_arr = [];
                $get_country_arr['flag'] = asset("uploads/Flags/".$C['sortname'].".png") ;
                $get_country_arr['id'] = $C['id'] ;
                $get_country_arr['sort_name'] = $C['sortname'] ;
                $get_country_arr['code'] = $C['phonecode'];
                $get_country_arr['label'] = $C['name'];
                $data[] = $get_country_arr;
            }
            
        }
        $output['data'] = $data;
        $output['status'] = true;
        $output['msg'] = 'Phone code list';


        return json_encode($output);

    }
}
