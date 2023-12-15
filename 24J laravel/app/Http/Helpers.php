<?php

use App\Models\Admin;
use App\Models\Information;
use App\Models\Settings;
use App\Models\Language;
use App\Models\ProductSetting;
use App\Models\Product;
use App\Models\CurrencySymbol;
use App\Models\ProuductCustomerGroupDiscount;
use App\Models\CurrencyRates;
use App\Models\Currency;
use App\Models\ProductOptionWeekTour;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

if (!function_exists('get_admin_data')) {
    function get_admin_data($id, $column = '')
    {
        if ($id != '') {
            $user_id = $id;
        } else {
            $user_id = Session::get('admin_id');
        }
        if (Session::get('user_type') == 'admin') {
            $get_admin = Admin::where('id', $user_id)->first();
        } else {
            $get_admin = User::where('id', $user_id)->first();
        }
        if ($get_admin) {
            if ($column != '') {
                if (array_key_exists($column, $get_admin->toArray())) {
                    return $get_admin[$column];
                }
            } else {
                return $get_admin;
            }
        }
    }
}

if (!function_exists('print_die')) {
    function print_die($arr = [])
    {
        echo '<pre>';
        print_r($arr);
        echo '<pre/>';
        die();
    }
}

if (!function_exists('get_setting_data')) {
    function get_setting_data($meta_title = '', $column = '', $condition = '')
    {
        $value = '';
        if ($column == '') {
            $column = 'content';
        }
        if ($meta_title != '') {
            $get_setting = Settings::where('meta_title', $meta_title);
            if ($condition != '') {
                $get_setting->where('child_meta_title', $condition);
            }
            $get_setting = $get_setting->orderby('id', 'desc')->first();
            if ($get_setting) {
                if ($get_setting[$column] != 'Empty') {
                    $value = $get_setting[$column];
                }
            }
        }
        return $value;
    }
}

if (!function_exists('get_table_data')) {
    function get_table_data($table_name = '', $column = '', $id = '', $search_column = 'id', $orderBy = "asc")
    {
        $value = '';
        if ($table_name != '') {
            $get_data = DB::table($table_name);
            if ($column != '') {
                if ($id != '') {
                    $get_data = $get_data->where($search_column, $id);
                }
                $get_data = $get_data->first();

                if ($get_data) {
                    if (array_key_exists($column, (array) $get_data)) {
                        $value = $get_data->$column;
                    }
                }
            }
        }
        return $value;
    }
}

// Get Topmenu Name
if (!function_exists('set_TopMenu')) {
    function set_TopMenu($el)
    {
        $TopMenu = Session::has('TopMenu');
        if ($TopMenu) {
            if (Session::get('TopMenu') == $el) {
                return ' active';
            } else {
                return false;
            }
        }
    }
}

// Get Submenu Name
if (!function_exists('set_SubMenu')) {
    function set_SubMenu($el)
    {
        $SubMenu = Session::has('SubMenu');
        if ($SubMenu) {
            if (Session::get('SubMenu') == $el) {
                return 'newactive';
            } else {
                return false;
            }
        }
    }
}

// Get Submenu Name
if (!function_exists('set_SubSubMenu')) {
    function set_SubSubMenu($el)
    {
        $SubMenu = Session::has('SubSubMenu');

        if ($SubMenu) {
            if (Session::get('SubSubMenu') == $el) {
                return 'newactive';
            } else {
                return false;
            }
        }
    }
}

// Get Collspse show or Hide
if (!function_exists('set_Collapse')) {
    function set_Collapse($el, $aria = false)
    {
        $set_Collapse = Session::has('TopMenu');
        if ($set_Collapse) {
            if (Session::get('TopMenu') == $el || Session::get('SubMenu') == $el) {
                if ($aria == false) {
                    return ' show';
                } else {
                    return 'true';
                }
            } else {
                return false;
            }
        }
    }
}

// get Tooltop Name
if (!function_exists('getTooltip')) {
    function getTooltip($module, $key)
    {
        $value = Information::where(['module' => $module, 'value_key' => $key])->first();
        if ($value != '') {
            return $value->desc;
        }
    }
}

// get Tablee Column
if (!function_exists('getTableColumn')) {
    function getTableColumn($table)
    {
        $tableColumn = Schema::getColumnListing($table);
        foreach ($tableColumn as $TC) {
            $ColumnArr[$TC] = '';
        }
        return $ColumnArr;
    }
}

// Decrypt Data
if (!function_exists('checkDecrypt')) {
    function checkDecrypt($el)
    {
        try {
            return Crypt::decrypt($el);
        } catch (DecryptException $e) {
            return false;
        }
    }
}

// Decrypt Data
if (!function_exists('checkPermission')) {
    function checkPermission()
    {
        if (Session::has('admin_id')) {
            if (Session::get('user_type') == 'admin') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

// get Language
if (!function_exists('translate')) {
    function translate($el)
    {
        $val = 'text_' . str_replace(' ', '_', strtolower($el));
        $arr = Lang::get('admin');

        $itHas = array_key_exists($val, $arr);

        if ($itHas == false) {
            $arr[$val] = $el;
            $path = \App::langPath() . '/en/admin.php';
            $output = "<?php\n\nreturn " . var_export($arr, true) . ";\n";
            $f = new Filesystem();
            $f->put($path, $output);
            return $el;
        } else {
            return __('admin.' . $val);
        }
    }
}

// Append Status Badge
if (!function_exists('checkStatus')) {
    function checkStatus($status)
    {
        if ($status == 'Active') {
            return "<span class='badge bg-success'>" . $status . '</span>';
        } else {
            return "<span class='badge bg-danger'>" . $status . '</span>';
        }
    }
}

// Append Status Badge
if (!function_exists('getLanguageTranslate')) {
    function getLanguageTranslate($array, $lang, $id, $column, $id_column)
    {
        $val = '';
        if (!empty($array)) {
            foreach ($array as $A) {

                if ($A['language_id'] == $lang && $A[$id_column] == $id) {
                    return $val = $A[$column];
                } else {
                    $val = '';
                }
            }
        }
        return $val;
    }
}

if (!function_exists('getLanguage')) {
    function getLanguage()
    {
        return Language::where(['is_delete' => 0, 'status' => 'Active'])->get();
    }
}


if (!function_exists('getSessionLang')) {
    function getSessionLang()
    {
        $lang_id =  Session::get('Lang');
        return Language::where(['id' => $lang_id, 'status' => 'Active'])->first();
    }
}

// Get Selected VAlue

if (!function_exists('getSelected')) {
    function getSelected($option, $value)
    {
        if ($option == $value) {
            return ' selected';
        }
    }
}

// Get Checked VAlue

if (!function_exists('getChecked')) {
    function getChecked($option, $value)
    {
        if ($option == $value) {
            return ' checked';
        }
    }
}

// Get PRoduct Settting Value

if (!function_exists('getProductSetting')) {
    function getProductSetting($type, $product_id, $meta_title)
    {
        $ProductSetting = ProductSetting::where(['product_id' => $product_id, 'type' => $type, 'meta_title' => $meta_title])->first();

        if ($ProductSetting) {
            if ($ProductSetting->meta_type == 'radio') {
                return 'on';
            } else {
                return $ProductSetting->meta_value;
            }
        }
    }
}

// Get PRoduct Settting Value

if (!function_exists('getSelectedInArray')) {
    function getSelectedInArray($value, $array)
    {
        if (!is_array($array)) {
            $array = explode(',', $array);
        }

        if (in_array($value, $array)) {
            return ' selected';
        }
    }
}

// Get PRoduct Settting Value

if (!function_exists('getDataFromDB')) {
    function getDataFromDB($table, $array = [], $type = '')
    {
        $getDataFromDB = DB::table($table);
        if (!empty($array)) {
            $getDataFromDB = $getDataFromDB->where($array);
        }

        if ($type == 'row') {
            return $getDataFromDB->first();
        } else {
            return $getDataFromDB->get()->toArray();
        }
    }
}

if (!function_exists('ConditionQuery')) {
    function ConditionQuery($val = '', $column = '')
    {
        return $arr = [
            $column . 'status' => 'Active',
            $column . 'is_delete' => 0,
        ];
    }
}

if (!function_exists('getAmount')) {
    function getAmount($val)
    {
        $currency = request()->currency;
        $CurrencySymbol = CurrencySymbol::where('code', $currency)->first();

        if ($CurrencySymbol) {
            $currency = $CurrencySymbol->symbol;
        }
        return $currency . " " . number_format($val, 2);
    }
}

if (!function_exists('ConvertCurrency')) {

    function ConvertCurrency($amount = 0, $ActiveCurrency = "")
    {
        $amount = (float) $amount;
        // $request = request()->currency;

        $to  =  request()->currency;


        $Currency = Currency::where('is_default', 1)->first();
        if ($to == "") {
            $to = $Currency->sort_code;
        }
        $baseCurrency = $Currency->sort_code;
        if ($ActiveCurrency != "") {
            $from  = $ActiveCurrency;
        } else {
            $from = $Currency->sort_code;
        }

        // if ($baseCurrency != $to) {
        $currentDatetime = carbon::now()->timestamp;

        $CurrencyRatesData = CurrencyRates::where(['base' => $from])->where('date', ">=", $currentDatetime)->first();
        if ($CurrencyRatesData) {
            $CurrencyRatesData = CurrencyRates::where(['base' => $from, 'country_code' => $to])->where('date', ">=", $currentDatetime)->first();
            if (!$CurrencyRatesData) {
                CurrencyRates::where(['base' => $from])->where('date', "<=", $currentDatetime)->delete();
                $req_url = 'https://api.exchangerate.host/latest?base=' . $from;
                $response_json = file_get_contents($req_url);
                if (false !== $response_json) {
                    try {
                        $response = json_decode($response_json);
                        if ($response->success === true) {
                            // var_dump($response);

                            foreach ($response->rates as $key => $value) {
                                $CurrencyRates  = new CurrencyRates();
                                $CurrencyRates['base'] = $response->base;
                                $CurrencyRates['date'] = Carbon::parse($response->date . " " . date("H:i:s"))->addMinute(5)->timestamp;
                                $CurrencyRates['country_code'] = $key;
                                $CurrencyRates['rate'] = $value;
                                $CurrencyRates->save();
                            }
                            $CurrencyRatesData = CurrencyRates::where(['base' => $from, 'country_code' => $to])->where('date', "<", $currentDatetime)->first();
                            // return round($amount * $CurrencyRatesData->rate, 2);
                            return round($amount * $CurrencyRatesData->rate);
                        }
                    } catch (Exception $e) {
                        return round($amount);
                    }
                }
            }

            return round($amount * (float) $CurrencyRatesData->rate);
        } else {

            CurrencyRates::where(['base' => $from])->where('date', "<=", $currentDatetime)->delete();
            $req_url = 'https://api.exchangerate.host/latest?base=' . $from;
            $response_json = file_get_contents($req_url);
            if (false !== $response_json) {
                try {
                    $response = json_decode($response_json);
                    if ($response->success === true) {
                        // var_dump($response);

                        foreach ($response->rates as $key => $value) {
                            $CurrencyRates  = new CurrencyRates();
                            $CurrencyRates['base'] = $response->base;
                            $CurrencyRates['date'] = Carbon::parse($response->date . " " . date("H:i:s"))->addMinute(5)->timestamp;
                            $CurrencyRates['country_code'] = $key;
                            $CurrencyRates['rate'] = $value;
                            $CurrencyRates->save();
                        }
                        $CurrencyRatesData = CurrencyRates::where(['base' => $from, 'country_code' => $to])->where('date', "<", $currentDatetime)->first();
                        return round($amount * $CurrencyRatesData->rate);
                    }
                } catch (Exception $e) {
                    return round($amount);
                }
            }
        }
        // } else {

        //     return round($amount, 2);
        // }
    }
}



if (!function_exists('getAllInfo')) {
    function getAllInfo($table, $condition, $column)
    {
        $getProductInfo = DB::table($table)
            ->where($condition)
            ->first();
        if ($getProductInfo) {
            return $getProductInfo->$column;
        }
    }
}

if (!function_exists('createSlug')) {
    function createSlug($table, $title, $id = 0)
    {
        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($title)));
        $allSlugs = getRelatedSlugs($table, $slug, $id);
        if (!$allSlugs->contains('slug', $slug)) {
            return $slug;
        }
        $i = 1;
        $is_contain = true;
        do {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                $is_contain = false;
                return $newSlug;
            }
            $i++;
        } while ($is_contain);
    }
}

if (!function_exists('getRelatedSlugs')) {
    function getRelatedSlugs($table, $slug, $id = 0)
    {
        return DB::table($table)
            ->select('slug')
            ->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }
}

// Validatio Email
if (!function_exists('emailValidate')) {
    function emailValidate($table, $column, $validate_parm, $user_type = '')
    {
        $get_data = DB::table($table)->where($column, $validate_parm);
        if ($user_type != '') {
            $get_data = $get_data->where($column, $validate_parm);
        }
        $get_data = $get_data->count();
        return $get_data;
    }
}

// Get Unique Otp
if (!function_exists('unique_otp')) {
    function unique_otp($table, $column)
    {
        do {
            $otp_code = rand(100000, 1000000);
        } while (
            DB::table($table)
            ->where($column, $otp_code)
            ->exists()
        );

        return $otp_code;
    }
}

// Get Unique Affiliate Code
if (!function_exists('unique_affiliate_code')) {
    function unique_affiliate_code($table, $column)
    {
        do {
            $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

            $code = substr(str_shuffle(str_repeat($pool, 5)), 0, 12);
        } while (
            DB::table($table)
            ->where($column, $code)
            ->exists()
        );

        return $code;
    }
}

// Get Unique Affiliate Code
if (!function_exists('generate_product_link')) {
    function generate_product_link($table, $product_id, $user_id, $page)
    {
        $LinkCount = DB::table($table)
            ->where(['product_id' => $product_id, 'user_id' => $user_id])
            ->count();

        if ($LinkCount > 0) {
            $Product = Product::find($product_id);
            $User = User::find($user_id);
            if ($Product != '' && $User != '') {
                // env("APP_URL")
                return env('APP_URL') . $page . '/' . $Product->slug . '/' . $User->affiliate_code;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}

if (!function_exists('get_rating')) {
    function get_rating($product_id)
    {
        if ($product_id) {
            $review_count = DB::table('user_review')
                ->where(['product_id' => $product_id])
                ->count();
            $review_sum = DB::table('user_review')
                ->where(['product_id' => $product_id])
                ->sum('user_review.rating');
            $total_review = 0;
            if ($review_sum > 0 && $review_count > 0) {
                $total_review = $review_sum / $review_count;
                return substr($total_review, 0, 3);
            } else {
                $random_review = 0;
                $get_random_review = DB::table('products')
                    ->where(['id' => $product_id])
                    ->first();
                if ($get_random_review) {
                    $random_review = $get_random_review->random_rating;
                }
                return $random_review;
            }
        } else {
            return 0;
        }
    }
}

if (!function_exists('get_ratings_stars')) {
    function get_ratings_stars($product_id)
    {
        $averageScore = get_rating($product_id);
        $wholeStarCount = (int) $averageScore;
        $noStarCount = (int) (5 - $averageScore);
        $hasHalfStar = $averageScore - $wholeStarCount > 0;
        $stars = str_repeat('<i class="fa fa-star text-warning"></i>' . PHP_EOL, $wholeStarCount) . ($hasHalfStar ? '<i class="fa fa-star-half-alt text-warning star-icon"></i>' . PHP_EOL : '') . str_repeat('<i class="far fa-star"></i>' . PHP_EOL, $noStarCount);

        echo $stars;
    }
}

if (!function_exists('get_ratings_count')) {
    function get_ratings_count($product_id)
    {
        $get_ratings_arr = [];
        $arr = [5, 4, 3, 2, 1];
        $totalReview = DB::table('user_review')
            ->where('product_id', $product_id)
            ->count();

        foreach ($arr as $key => $value) {
            $reviews = DB::table('user_review')
                ->selectRaw('SUM(rating) as ratings_sum')
                ->selectRaw('ROUND(rating) as ratings_round')
                ->selectRaw('COUNT(ROUND(rating)) as rating_count')
                ->where('product_id', $product_id)
                ->having('ratings_round', $value)
                ->groupBy('ratings_round')
                ->orderBy('rating', 'asc')
                ->first();
            if ($reviews) {
                $new_review['ratings_round'] = $reviews->ratings_round;
                $new_review['rating_count'] = $reviews->rating_count;
                $new_review['ratings_sum'] = $reviews->ratings_sum;
                $total_review = 0;
                if ($reviews->ratings_sum > 0 && $reviews->rating_count > 0) {
                    $total_review = ($reviews->rating_count / $reviews->ratings_sum) * 100;
                }
                $new_review['ratings_calculate'] = number_format($total_review, 2);
                $new_review['rating_calcualtion'] = ($reviews->rating_count / $totalReview) * 100;
                if ($value == 5) {
                    $color = 'rgb(17 114 45)';
                } elseif ($value == 4) {
                    $color = 'rgb(36 163 73)';
                } elseif ($value == 3) {
                    $color = 'rgb(22 212 78)';
                } elseif ($value == 2) {
                    $color = 'rgb(246 189 20)';
                } else {
                    $color = 'rgb(246 73 20)';
                }

                $new_review['color'] = $color;
            } else {
                $new_review['ratings_round'] = $value;
                $new_review['rating_count'] = 0;
                $new_review['ratings_sum'] = 0;
                $new_review['ratings_calculate'] = 0;
                $new_review['rating_calcualtion'] = 0;
                $new_review['color'] = '';
            }
            $get_ratings_arr[] = $new_review;
        }
        return $get_ratings_arr;
    }
}

if (!function_exists('check_table_count')) {
    function check_table_count($table_name, $id, $column)
    {
        $review_count = DB::table($table_name)
            ->where($column, $id)
            ->count();
        return $review_count;
    }
}

if (!function_exists('short_description_limit')) {
    function short_description_limit($text, $limit = 60)
    {
        $return_text = '';
        if ($text != '') {
            $return_text = strlen($text) > $limit ? Str::limit($text, $limit) : $text;
        }
        return $return_text;
    }
}

if (!function_exists('get_price_front')) {
    function get_price_front($product_id, $user_id = '', $type, $currency = '')
    {

        $to = request()->currency;
        $CurrencySymbol = CurrencySymbol::where('code', $to)->first();
        $currency = $to;
        if ($CurrencySymbol) {
            $currency = $CurrencySymbol->symbol;
        }

        if ($product_id != '') {


            $get_product = DB::table('products')
                ->where('id', $product_id)
                ->first();
            $selling_price = ConvertCurrency($get_product->selling_price);
            $original_price = ConvertCurrency($get_product->original_price);

            if ($user_id != '') {
                $user_id = checkDecrypt($user_id);
                $get_user = DB::table('users')
                    ->where('id', $user_id)
                    ->where('user_type', 'Partner')
                    ->where('is_verified', 1)
                    ->where('is_delete', 0)
                    ->where('status', 'Active')
                    ->first();
                if ($get_user) {
                    $customer_group = $get_user->customer_group;
                    if ($customer_group) {
                        $customer_group_discount = ProuductCustomerGroupDiscount::where(['product_id' => $product_id, 'customer_group_id' => $customer_group, 'type' => $type])->first();
                        if ($customer_group_discount) {
                            $dicounted_amount = 0;
                            $base_price_percent = $customer_group_discount['base_price'];
                            if ($base_price_percent > 0 && $base_price_percent != '') {
                                $dicounted_amount = ($base_price_percent / 100) * $selling_price;
                            }
                            $selling_price = $selling_price - $dicounted_amount;
                        }
                    }
                }
            }
            $html = '';
            if ($get_product) {
                $html = '';
                $html .=
                    '<p class="starting_at">Starting From</p>
                                <div class="starting_prd_price">
                                    <p class="rate_price">
                                        <span>' .
                    $currency .
                    ' </span>';
                $html .= $selling_price;
                $html .= ' </p>';
                if ($original_price != '' && $original_price > 0) {
                    $html .= '<span class="real_price">';
                    $html .= '<span class="aed_txt">' . $currency . ' </span>' . $original_price;
                    $html .= '</span>';
                }

                $html .= '</div>';
                // $html .= '</div>';
            }
            return $html;
        }
    }
}

if (!function_exists('get_price_front_detail')) {
    function get_price_front_detail($product_id, $user_id = '', $type, $currency = '')
    {
        $to = request()->currency;
        $CurrencySymbol = CurrencySymbol::where('code', $to)->first();
        $currency = $to;
        if ($CurrencySymbol) {
            $currency = $CurrencySymbol->symbol;
        }
        if ($product_id != '') {

            $get_product = DB::table('products')
                ->where('id', $product_id)
                ->first();
            $selling_price = ConvertCurrency($get_product->selling_price);
            $original_price = ConvertCurrency($get_product->original_price);

            if ($user_id != '') {
                if (strlen($user_id) > 10) {
                    $user_id = checkDecrypt($user_id);
                }
                $get_user = DB::table('users')
                    ->where('id', $user_id)
                    ->where('user_type', 'Partner')
                    ->where('is_verified', 1)
                    ->where('is_delete', 0)
                    ->where('status', 'Active')
                    ->first();
                if ($get_user) {
                    $customer_group = $get_user->customer_group;
                    if ($customer_group) {
                        $customer_group_discount = ProuductCustomerGroupDiscount::where(['product_id' => $product_id, 'customer_group_id' => $customer_group, 'type' => $type])->first();
                        if ($customer_group_discount) {
                            $dicounted_amount = 0;
                            $base_price_percent = $customer_group_discount['base_price'];
                            if ($base_price_percent > 0 && $base_price_percent != '') {
                                $dicounted_amount = ($base_price_percent / 100) * $selling_price;
                            }
                            $selling_price = $selling_price - $dicounted_amount;
                        }
                    }
                }
            }

            if ($type == 'limousine' || $type == 'yacht') {
                $WeekDay = Carbon::now()->dayName;
                $ProductOptionWeekTour = ProductOptionWeekTour::where(['product_id' => $product_id, 'for_general' => 1, 'week_day' => $WeekDay])->first();
                if ($ProductOptionWeekTour) {
                    $getamount = ConvertCurrency($ProductOptionWeekTour->adult);
                    $selling_price = get_partners_dis_price($getamount, $product_id, $user_id, 'weekdays', 'limousine');
                    $original_price = 0;
                } else {
                    if ($get_product->selling_price !== '') {
                        $selling_price = get_partners_dis_price(ConvertCurrency($get_product->selling_price), $product_id, $user_id, 'base_price', 'limousine');
                        $original_price = 0;
                    } else {
                        $selling_price = get_partners_dis_price(ConvertCurrency($get_product->selling_price), $product_id, $user_id, 'base_price', 'limousine');
                        $original_price = get_partners_dis_price(ConvertCurrency($get_product->original_price), $product_id, $user_id, 'base_price', 'limousine');
                    }
                }
            }

            $html = '';
            if ($get_product) {
                $html .=
                    '<p>
                            <span class="aed_txt">' .
                    $currency .
                    '</span>
                            ' .
                    $selling_price .
                    '
                            <span class="per_txt">
                            Per ' .
                    $get_product->per_value .
                    '
                            </span>
                        </p>';
                if ($original_price != '' && $original_price > 0) {
                    $html .=
                        '<span class="real_price">
                                <span class="aed_txt">' .
                        $currency .
                        '</span>
                            ' .
                        $original_price .
                        '
                            </span>';
                }
            }
            return $html;
        }
    }
}

if (!function_exists('get_partners_dis_price')) {
    function get_partners_dis_price($price, $product_id, $user_id = '', $dis_type = '', $product_type = '', $currency = '')
    {
        $return_price = $price;
        if ($product_id != '') {
            if ($currency == '') {
                $currency = 'AED';
            }

            $get_product = DB::table('products')
                ->where('id', $product_id)
                ->first();
            if ($get_product) {
                if ($user_id != '') {
                    if (strlen($user_id) > 10) {
                        $user_id = checkDecrypt($user_id);
                    }
                    $get_user = DB::table('users')
                        ->where('id', $user_id)
                        ->where('user_type', 'Partner')
                        ->where('is_verified', 1)
                        ->where('is_delete', 0)
                        ->where('status', 'Active')
                        ->first();

                    if ($get_user) {
                        $customer_group = $get_user->customer_group;
                        if ($customer_group) {
                            $customer_group_discount = ProuductCustomerGroupDiscount::where(['product_id' => $product_id, 'customer_group_id' => $customer_group, 'type' => $product_type])->first();

                            if ($customer_group_discount) {
                                $dicounted_amount = 0;
                                $base_price_percent = $customer_group_discount[$dis_type];

                                if ($base_price_percent > 0 && $base_price_percent != '') {
                                    $dicounted_amount = ($base_price_percent / 100) * $price;
                                }
                                $return_price = $price - $dicounted_amount;
                            }
                        }
                    }
                }
            }
        }
        return $return_price;
    }
}

if (!function_exists('get_cancelled_time')) {
    function get_cancelled_time($cancell_time, $order_date, $prams)
    {
        $return_date = '';
        // if ($cancell_time > 0) {
        $Cancel_time = $cancell_time;
        $time_string = explode('-', $Cancel_time);
        $order_date_ = Carbon::create($order_date);

        $Cancellation_date = $order_date_
            ->addDays($time_string[0])
            ->addHours($time_string[1])
            ->addMinute($time_string[2]);
        $Cancellation_timestamp = strtotime($Cancellation_date);
        if ($prams == 'cancellation_up_to_time') {
            $return_date = $Cancellation_date;
        } else {
            $return_date = $Cancellation_timestamp;
        }
        // }
        return $return_date;
    }
}

if (!function_exists('change_str')) {
    function change_str($value)
    {
        $changeValue = str_replace('<pre>', '<p>', $value);
        $finalValue = str_replace('</pre>', '</p>', $changeValue);

        return $finalValue;
    }
}

// ------ Send  NOtification on FireBase
if (!function_exists('send_notification_firebase')) {
    function send_notification_firebase($id, $table = 'firebase_tokens', $column = 'token')
    {
        $get_notificaion = DB::table('notification')
            ->where('id', $id)
            ->first();
        if ($get_notificaion) {
            $firebase_token_arr = [];
            $get_data = DB::table($table)->get();
            if (!$get_data->isEmpty()) {
                foreach ($get_data as $key => $value) {
                    # code...
                    if (isset($value->token)) {
                        $firebase_token_arr[] = $value->token;
                    }
                }
            }

            if (count($firebase_token_arr) > 0) {
                $from = 'AAAA-_Qd7hU:APA91bF0DOGrPTYWvtTxkWKEwC85EvRBj6IDGrrUdwRxcUOcXVORILeg56yXAU7a6gBXveZCXYKO4JFMX91WHOgXvGzaQjbvWR4X-OZu6yxHwB5K1SW2qQ39kEJSSnL3z48vCNYuJ4LU';
                // $from = 'AAAAGPJJTGM:APA91bH_X7CtIuySJDNW-uD4XgYBkoF9EOBjcEFfREAqAGgnmbEWXOwMQtjL-w7DGe5UjPVJjmmlt8TWpb3Neox1RvrG_zpJO_q41oO3cjMaJByrp60mKwjp0ZVDAUpRgFkOJNmkWZ44';
                // $data['link'] = $get_notificaion->link != '' ? $get_notificaion->link : '';

                $notification_data = [
                    'url' => $get_notificaion->link != '' ? $get_notificaion->link : '',
                    'click_action' => $get_notificaion->link != '' ? $get_notificaion->link : '',
                    'image' => $get_notificaion->image != '' ? url('uploads/notification', $get_notificaion->image) : asset('uploads/placeholder/placeholder.png'),
                    'title' => $get_notificaion->title != '' ? $get_notificaion->title : '',
                    'body' => $get_notificaion->description != '' ? $get_notificaion->description : '',
                    'receiver' => 'erw',
                    'icon' => $get_notificaion->icon != '' ? url('uploads/notification', $get_notificaion->icon) : asset('uploads/placeholder/placeholder.png') /*Default Icon*/,
                    'sound' => 'mySound' /*Default sound*/,
                    // 'data' => $data /*Default sound*/,
                ];

                $extra_msg = [
                    'message' => 'New Order Received',
                    'click_action' => $get_notificaion->link != '' ? $get_notificaion->link : '',
                ];



                $fields = [
                    'registration_ids' => $firebase_token_arr,
                    'notification' => $notification_data,
                ];


                $headers = ['Authorization: key=' . $from, 'Content-Type: application/json'];
                //#Send Reponse To FireBase Server
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);
                curl_close($ch);
                // print_die($result);
            }
        }
    }
}


if (!function_exists('getWeatherDetails')) {
    function getWeatherDetails($location)
    {
        $WEATHER_KEY = env("WEATHER_KEY");
        $location = urlencode($location);
        // print_die($location);
        $response = "";
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.weatherapi.com/v1/forecast.json?key=' . $WEATHER_KEY . '&q=' . $location,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
        ));
        
        if (curl_exec($curl) === false) {
        } else {
            $response = curl_exec($curl);
            $response = json_decode($response);
            if (isset($response->error)) {
                $response = "";
            }
        }
        
        
        
        curl_close($curl);
        
        return $response;
    }
}

if (!function_exists('giftCardrandomId')) {
    
    function giftCardrandomId(){
        $id = Str::random(4).'-'.rand(9999,1000).'-'.Str::random(4);
        $id = strtoupper($id);
        $product_checkout_giftcard = DB::table('product_checkout_giftcard')
            ->where('gift_card_code',$id)
            ->first();
        if ($product_checkout_giftcard) {
            return $this->giftCardrandomId();
        }
        
        return $id;
    }
}