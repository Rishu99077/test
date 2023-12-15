<?php

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
use App\Models\Settings;
use App\Models\Product;
use App\Models\PartnerProductReason;
use App\Models\Wishlist;
use App\Models\Admin;
use App\Models\Languages;
use App\Models\Pagemeta;
use App\Models\ProductLocation;
use App\Models\ProductOption;
use App\Models\ProductImages;
use App\Models\ProductOptionPricingTiers;
use App\Models\ProductOptionPricing;
use App\Models\ProductOptionDiscount;
use App\Models\ProductOptionPricingDetails;
use App\Models\ProductOptionAvailability;
use App\Models\UserReview;
use Illuminate\Support\Str;
use Carbon\CarbonPeriod;
use Stichoza\GoogleTranslate\GoogleTranslate;


if (!function_exists('get_admin_data')) {
    function get_admin_data($id, $column = '')
    {
        if ($id != '') {
            $user_id = $id;
        } else {
            $user_id = Session::get('em_admin_id');
        }
        $get_admin = Admin::where('id', $user_id)->first();
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
    function get_table_data($table_name = '', $column = '', $id = '', $search_column = 'id')
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



// get Languages
if (!function_exists('translate')) {
    function translate($el)
    {

        // Session Language
        $get_session_language     = getLang();
        $sort_code = $get_session_language['sort_code'];

        // get folder Path
        $folderPath = base_path() . '/resources/lang/';
        $totalFolders = glob($folderPath . "*");



        $val = 'text_' . str_replace(' ', '_', strtolower($el));
        $arr = Lang::get('admin');


        // Enter in Another language Filer
        foreach ($totalFolders as $TF) {
            $langarr = "";
            $pieces = explode('/', $TF);
            $langCode = array_pop($pieces);
            if ($langCode != "en") {

                $langarr = File::getRequire(base_path() . '/resources/lang/' . $langCode . '/admin.php');

                if (is_array($langarr)) {
                    $itHas = array_key_exists($val, $langarr);

                    if ($itHas == false) {

                        try {
                            $translator = new GoogleTranslate();
                            $translator->setSource(); // Detect language automatically
                            $translator->setTarget($langCode);
                            // Translate the text
                            $translatedText = $translator->translate($el);
                            $langarr[$val] = $translatedText;
                            $path = \App::langPath() . '/' . $langCode . '/admin.php';
                            $output = "<?php\n\nreturn " . var_export($langarr, true) . ";\n";
                            $f = new Filesystem();
                            $f->put($path, $output);
                        } catch (Exception $e) {
                        }
                    }
                }
            }
        }

        $itHas = array_key_exists($val, $arr);

        if ($itHas == false) {
            $arr[$val] = $el;
            $path = \App::langPath() . '/en/admin.php';
            $output = "<?php\n\nreturn " . var_export($arr, true) . ";\n";
            $f = new Filesystem();
            $f->put($path, $output);

            $newarr = File::getRequire(base_path() . '/resources/lang/' . strtolower($sort_code) . '/admin.php');

            return $newarr[$val];
            // return $el;


        } else {
            $arr = File::getRequire(base_path() . '/resources/lang/' . strtolower($sort_code) . '/admin.php');

            return $arr[$val];
        }
    }
}


function oldTranslate($el)
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

// Append Status Badge
if (!function_exists('checkStatus')) {
    function checkStatus($status)
    {
        if (
            $status == 'Active' || $status == 'active' || $status == 'verified' || $status == 'success' || $status == 'Success' ||
            $status == "Credited"
        ) {
            return "<span class='badge bg-success'>" . strtoupper($status) . '</span>';
        } elseif ($status == 'Draft' || $status == 'draft' || $status == "Pending") {
            return "<span class='badge bg-warning'>" . strtoupper($status) . '</span>';
        } else {
            return "<span class='badge bg-danger'>" . strtoupper($status) . '</span>';
        }
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
    function getDataFromDB($table, $array = [], $type = '', $column = "")
    {
        $getDataFromDB = DB::table($table);
        if (!empty($array)) {
            $getDataFromDB = $getDataFromDB->where($array);
        }

        if ($type == 'row') {
            if ($column != "") {
                $data =  $getDataFromDB->first();
                if ($data) {
                    if ($data->$column) {
                        return $data->$column;
                    } else {
                        return "";
                    }
                } else {
                    return "";
                }
            } else {
                return $getDataFromDB->first();
            }
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
        return 'AED ' . round($val, 2);
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
        $slug     = url_slug($title);
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

if (!function_exists('url_slug')) {
    function url_slug($str, $options = array())
    {
        // Make sure string is in UTF-8 and strip invalid UTF-8 characters
        //$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => false,
        );

        // Merge options
        $options = array_merge($defaults, $options);

        $char_map = array(
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
            'ß' => 'ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
            'ÿ' => 'y',

            // Latin symbols
            '©' => '(c)',

            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',

            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',

            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
            'Ž' => 'Z',
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z',

            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
            'Ż' => 'Z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',

            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z'
        );

        // Make custom replacements
        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

        // Transliterate characters to ASCII
        if ($options['transliterate']) {
            $str = str_replace(array_keys($char_map), $char_map, $str);
        }

        // Replace non-alphanumeric characters with our delimiter
        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

        // Remove duplicate delimiters
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

        // Truncate slug to max. characters
        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

        // Remove delimiter from ends
        $str = trim($str, $options['delimiter']);

        return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }
}


if (!function_exists('getRelatedSlugs')) {
    function getRelatedSlugs($table, $slug, $id = 0)
    {

        return DB::table($table)
            ->select('slug')
            ->where('slug', 'like', '%' . $slug . '%')
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

if (!function_exists('getLang')) {
    function getLang()
    {
        $Language =  Languages::whereNull('is_delete')->where(['is_default' => '1', 'status' => 'Active'])->first();
        $lang_id =  Session::get('Lang');
        if ($lang_id != '') {
            $Language =  Languages::whereNull('is_delete')->where(['id' => $lang_id, 'status' => 'Active'])->first();
        }
        return $Language;
    }
}



// check empty array
if (!function_exists('emptyArray')) {
    function emptyArray($NewArray, $column = "")
    {
        $empty = "";
        if (!empty($NewArray) && $column != "") {
            foreach ($NewArray as $key => $A) {
                return $empty = $A[$column];
            }
        } else {
            $empty = "";
        }
        return $empty;
    }
}


// get New Language Data
function getLanguageData($table, $lang, $id, $id_column, $original = false)
{
    $data  = getTableColumn($table);

    $is_api = false;
    if (request()->is('api/*')) {
        $is_api = true;
    }


    if ($original) {
    } else {

        $Language =  Languages::whereNull('is_delete')->where(['status' => 'Active'])->first();
        if ($Language) {
            $Language =  Languages::whereNull('is_delete')->where(['status' => 'Active'])->pluck('id')->toArray();
            $query = DB::table($table)->where([$id_column => $id])->whereIn('language_id', $Language)->get();
            if ($query) {
                foreach ($query as $key => $value) {
                    foreach ($value as $vkey => $record) {
                        if ($data[$vkey] == '' && $record && $record != '' && $record !== null) {
                            $data[$vkey] = $record;
                        }
                    }
                }
            }

            if ($is_api) {
                $Language =  Languages::whereNull('is_delete')->where(['is_default' => '1', 'status' => 'Active'])->first();
                if ($Language) {
                    if ($Language->id) {
                        $query = DB::table($table)->where([$id_column => $id, 'language_id' => $Language->id])->get();
                        if ($query) {
                            foreach ($query as $key => $value) {
                                foreach ($value as $vkey => $record) {
                                    if ($data[$vkey] == '' && $record && $record != '' && $record !== null) {
                                        $data[$vkey] = $record;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }


    $query = DB::table($table)->where([$id_column => $id, 'language_id' => $lang])->first();
    if ($query) {
        $query = (array)$query;
        foreach ($query as $key => $value) {


            // $Language = Languages::where(['is_delete' => 0, 'status' => 'Active', 'id' => $value])->first();
            // if ($Language) {
            if ($value && $value != '' && $value !== null) {
                $data[$key] = $value;
                // }
            }
        }
    }

    return $data;
}

if (!function_exists('image_upload')) {
    function image_upload($img, $path)
    {
        $random_no  = uniqid();
        $mime_type  =  $img->getMimeType();
        $ext        = $img->getClientOriginalExtension();
        $new_name   = time() . '_' . $random_no . '.' . $ext;
        $destinationPath =  public_path($path);
        $img->move($destinationPath, $new_name);
        return $new_name;
    }
}


if (!function_exists('image_delete')) {
    function image_delete($image_name)
    {
        if ($image_name != '') {
            $image_path = public_path($image_name);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
    }
}

function getPagemeta($arr, $lang, $page_id, $url = false)
{
    $data = array();
    foreach ($arr as $key => $value) {
        $data[$value] = '';
    }

    $Language =  Languages::whereNull('is_delete')->where(['status' => 'Active'])->first();
    if ($Language) {
        $Language =  Languages::whereNull('is_delete')->where(['status' => 'Active'])->pluck('id')->toArray();
        if ($page_id) {
            $Pagemeta =  Pagemeta::where(['page_id' => $page_id])->whereIn('language_id', $Language)->whereIn('meta_key', $arr)->get();
        } else {
            $Pagemeta =  Pagemeta::whereNull('page_id')->whereIn('language_id', $Language)->whereIn('meta_key', $arr)->get();
        }
        foreach ($Pagemeta as $key => $value) {
            if ($value->type == 'File' and $url) {
                $data[$value->meta_key] = asset('uploads/pages') . '/' . $value->meta_value;
            } else {
                $data[$value->meta_key] = $value->meta_value;
            }
        }

        $Language =  Languages::whereNull('is_delete')->where(['is_default' => '1', 'status' => 'Active'])->first();
        if ($Language) {
            if ($page_id) {
                $Pagemeta =  Pagemeta::where(['page_id' => $page_id])->where('language_id', $Language->id)->whereIn('meta_key', $arr)->get();
            } else {
                $Pagemeta =  Pagemeta::whereNull('page_id')->where('language_id', $Language->id)->whereIn('meta_key', $arr)->get();
            }
            foreach ($Pagemeta as $key => $value) {
                if ($value->type == 'File' and $url) {
                    $data[$value->meta_key] = asset('uploads/pages') . '/' . $value->meta_value;
                } else {
                    $data[$value->meta_key] = $value->meta_value;
                }
            }
        }

        $Language =  Languages::whereNull('is_delete')->where(['id' => $lang, 'status' => 'Active'])->first();
        if ($Language) {
            if ($page_id) {
                $Pagemeta =  Pagemeta::where(['page_id' => $page_id])->where('language_id', $lang)->whereIn('meta_key', $arr)->get();
            } else {
                $Pagemeta =  Pagemeta::whereNull('page_id')->where('language_id', $lang)->whereIn('meta_key', $arr)->get();
            }
            foreach ($Pagemeta as $key => $value) {
                if ($value->type == 'File' and $url) {
                    $data[$value->meta_key] = asset('uploads/pages') . '/' . $value->meta_value;
                } else {
                    $data[$value->meta_key] = $value->meta_value;
                }
            }
        }
    }
    return $data;
}


function getPagemeta_multi($arr, $lang, $page_id, $meta_key, $url = false)
{
    $datanew = array();
    $Language =  Languages::whereNull('is_delete')->where(['status' => 'Active'])->first();
    if ($Language) {
        $data = array();
        $Language =  Languages::whereNull('is_delete')->where(['status' => 'Active'])->pluck('id')->toArray();
        if ($page_id) {
            $Pagemeta =  Pagemeta::where(['page_id' => $page_id])->whereIn('language_id', $Language)->where('meta_key', $meta_key)->get();
        } else {
            $Pagemeta =  Pagemeta::whereNull('page_id')->whereIn('language_id', $Language)->where('meta_key', $meta_key)->get();
        }
        foreach ($Pagemeta as $key => $value) {
            if ($value->type == 'File' and $url) {
                $data[$value->order_index][$value->child_row] = asset('uploads/pages') . '/' . $value->meta_value;
            } else {
                $data[$value->order_index][$value->child_row] = $value->meta_value;
            }
        }

        $Language =  Languages::whereNull('is_delete')->where(['is_default' => '1', 'status' => 'Active'])->first();
        if ($Language) {
            if ($page_id) {
                $Pagemeta =  Pagemeta::where(['page_id' => $page_id])->where('language_id', $Language->id)->where('meta_key', $meta_key)->get();
            } else {
                $Pagemeta =  Pagemeta::whereNull('page_id')->where('language_id', $Language->id)->where('meta_key', $meta_key)->get();
            }
            foreach ($Pagemeta as $key => $value) {

                if ($value->type == 'File' and $url) {
                    $data[$value->order_index][$value->child_row] = asset('uploads/pages') . '/' . $value->meta_value;
                } else {
                    $data[$value->order_index][$value->child_row] = $value->meta_value;
                }
            }
        }

        $Language =  Languages::whereNull('is_delete')->where(['id' => $lang, 'status' => 'Active'])->first();
        if ($Language) {
            if ($page_id) {
                $Pagemeta =  Pagemeta::where(['page_id' => $page_id])->where('language_id', $lang)->where('meta_key', $meta_key)->get();
            } else {
                $Pagemeta =  Pagemeta::whereNull('page_id')->where('language_id', $lang)->where('meta_key', $meta_key)->get();
            }
            foreach ($Pagemeta as $key => $value) {
                if ($value->type == 'File' and $url) {
                    $data[$value->order_index][$value->child_row] = asset('uploads/pages') . '/' . $value->meta_value;
                } else {
                    $data[$value->order_index][$value->child_row] = $value->meta_value;
                }
            }
        }

        foreach ($data as $key => $value) {
            $datanew[$key] = array_merge($arr, $value);
        }
    }
    return $datanew;
}

if (!function_exists('get_url_segment')) {
    function get_url_segment()
    {
        return Request::segment(2);
    }
}

if (!function_exists('get_active_tab')) {
    function get_active_tab($segment, $tab)
    {
        $class = "";
        if ($segment == $tab) {
            $class = " active show";
            return $class;
        }
        return $class;
    }
}


if (!function_exists('getIsset')) {
    function getIsset($data, $col)
    {
        $returnData = "";
        if (isset($data)) {
            $returnData =  $data->$col;
        }
        return $returnData;
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

if (!function_exists('getProductArr')) {
    function getProductArr($arr, $language_id, $user_id = '', $is_list = 0)
    {
        $get_arr = [];


        foreach ($arr as $key => $P) {
            if ($P) {
                $ProductOptionPricingCount =  ProductOptionPricing::where(['product_id' => $P['id']])->count();
                $ProductImages = ProductImages::where(['product_id' => $P['id']])->first();
                $ProductDescription  = getLanguageData('products_description', $language_id, $P['id'], 'product_id');
                $file = 'dummyproduct.png';
                if ($P['cover_image'] != "") {
                    $file = $P['cover_image'];
                } else {
                    if ($ProductImages) {
                        $file = $ProductImages->image;
                    }
                }

                $userid = checkDecrypt($user_id);






                $is_wishlist = Wishlist::where(['product_id' => $P['id'], 'user_id' => $userid])->count();

                $get_product                       = [];

                $get_product['id']                 = $P['id'];
                $get_product['for_approvel']       = $P['for_approvel'];
                $get_product['image']              = asset('uploads/all_thumbnails/' . $file);
                $get_product['title']              = $ProductDescription['title']      != "" ? short_description_limit($ProductDescription['title']) : "No Title";
                $get_product['image_text']         = $ProductDescription['image_text'] != "" ? $ProductDescription['image_text'] : "";
                $get_product['slug']               = $P['slug'];
                $get_product['duration_text']      = $P['duration_text'];
                $get_product['activity_text']      = $P['activity_text'];
                $get_product['is_approved']        = $P['is_approved'];
                $get_product['status']             = $P['status'];
                $likely_to_sell_out                = ProductOption::where(['product_id' => $P['id'], 'status' => 'Active', 'likely_to_sell_out' => 'yes'])->count();
                $get_product['likely_to_sell_out'] = $likely_to_sell_out > 0  ? 'yes'  : 'no';
                $get_product['trip_details']       = ucfirst(str_replace('_', ' ', $P['type']));
                $get_product['is_wishlist']        = $is_wishlist;
                $get_product['price']              = $price                             = get_price_front($P['id']);
                $get_product['price_val']          = get_price_front($P['id'], '', '', '', '', '1');
                $get_product['ratings']            = get_rating($P['id']);
                $get_product['message']            = "";
                $get_product['total_review']       = UserReview::where('product_id', $P['id'])->where('status', 'Active')
                    ->count();
                $countProductOption = ProductOption::where(['product_id' => $P['id'], 'status' => 'Active', 'is_delete' => null])->count();
                $countProductOptionPricingDetails = ProductOptionPricingDetails::where(['product_id' => $P['id']])->count();
                if ($countProductOption == 0 || $countProductOptionPricingDetails == 0) {
                    $get_product['message'] = "This product option & pricing is incomplete.";
                }
                $ProductOption = ProductOption::where(['product_id' => $P['id'], 'status' => 'Active', 'is_delete' => null])->get();

                $checkAvailability = 0;
                $enable_date = [];
                foreach ($ProductOption as $POkey => $PO) {
                    $ProductOptionPricing = ProductOptionPricing::where(['product_id' => $P['id'], 'option_id' => $PO['id'], 'is_delete' => null])->first();
                    if ($ProductOptionPricing) {

                        $ProductOptionAvailability = ProductOptionAvailability::where(["product_id" => $P['id'], 'pricing_id' => $ProductOptionPricing->id, 'option_id' => $PO['id']])->first();

                        if ($ProductOptionAvailability) {
                            if ($ProductOptionAvailability->valid_from != "" && $ProductOptionAvailability->valid_to != "") {
                                $period = CarbonPeriod::create(date("Y-m-d", strtotime($ProductOptionAvailability->valid_from)), date("Y-m-d", strtotime($ProductOptionAvailability->valid_to)));
                                // Iterate over the period
                                $note_on_sale_date =  explode(',', $P['not_on_sale']);
                                foreach ($period as $date) {
                                    if ($date >= date("Y-m-d")) {
                                        $myDate =  $date->format('Y/m/d');
                                        $newDate =  $date->format('m/d/Y');

                                        $day =   Carbon::parse($myDate)->format('l');
                                        $day =  Str::lower(substr($day, 0, 3));
                                        $time_json = json_decode($ProductOptionAvailability->time_json);
                                        if ($time_json != '') {
                                            foreach ($time_json as $TJkey => $TJ) {
                                                if ($TJkey == $day) {
                                                    if ($TJ > 0 && $TJ != "") {
                                                        $newDate = date("Y-m-d", strtotime($myDate));
                                                        if (!in_array($newDate, $note_on_sale_date)) {
                                                            $enable_date[] =  $myDate;
                                                        }
                                                    }
                                                }
                                            }
                                        }



                                        if ($ProductOptionAvailability->date_json != "") {
                                            $date_json = json_decode($ProductOptionAvailability->date_json);
                                            if ($date_json != '') {
                                                foreach ($date_json as $DJkey => $DJ) {
                                                    if ($DJkey == date("Y-m-d", strtotime($myDate))) {
                                                        if ($DJ > 0 && $DJ != "") {
                                                            $newDate = date("Y-m-d", strtotime($myDate));

                                                            if (!in_array($newDate, $note_on_sale_date)) {
                                                                $enable_date[] =  $myDate;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                if (count($enable_date) == 0) {
                                    foreach ($period as $date) {
                                        if ($date >= date("Y-m-d")) {
                                            $enable_date[] = $date->format('Y/m/d');
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                if (count($enable_date) > 0) {
                    $checkAvailability = 1;
                    if ($is_list == 1) {
                        $ProductUser =  User::find($P['partner_id']);
                        if ($ProductUser) {
                            if ($ProductUser->status == "Active") {
                                $checkAvailability = 1;
                            } else {
                                $checkAvailability = 0;
                            }
                        }
                    }
                }

                $get_product['reason'] = "";

                $User = User::find($user_id);
                $PartnerProductReason = PartnerProductReason::where(['product_id' => $P['id'], 'partner_id' => $user_id])->orderBy('id', 'desc')->first();
                if ($User && $PartnerProductReason && $P['is_approved'] == "Not approved") {
                    $get_product['reason'] = $PartnerProductReason->reason;
                }

                if ($User && $is_list == 0) {
                    if ($User->user_type == "Partner") {
                        $checkAvailability = 1;
                    }
                }

                $get_product['country']  = "Country";
                $get_product['location'] = "Anywhere";
                $country = $P['country'];
                if ($country != "") {
                    $get_product['country']      = getDataFromDB('countries', ['id' => $country], 'row', 'name');
                    $get_product['location'] = getDataFromDB('countries', ['id' => $country], 'row', 'name');
                }

                $ProductLocation              = ProductLocation::where(['product_id' => $P['id']])->get();
                $ProductLocationArr           = [];
                foreach ($ProductLocation as $key => $PL) {
                    $get_location         = [];
                    $get_location       = explode(",", $PL['address']);
                    $ProductLocationArr[] = $get_location[0];
                }
                // $get_product['location'] = short_description_limit(implode(",", $ProductLocationArr), 35);
                if ($price != "" && $checkAvailability == 1) {
                    $get_arr[]                       = $get_product;
                }
            }
        }

        return $get_arr;
    }
}


if (!function_exists('get_price_front')) {
    function get_price_front($product_id = '', $type = 'listing', $user_id = '', $currency = '', $get_price = '', $only_price = '')
    {
        $currency = '$';
        $html = '';
        // $to = request()->currency;
        // $CurrencySymbol = CurrencySymbol::where('code', $to)->first();
        // $currency = $to;
        // if ($CurrencySymbol) {
        //     $currency = $CurrencySymbol->symbol;
        // }
        if ($get_price != '') {

            if ($get_price > 0) {
            } else {
                $get_price = 0;
            }
            return $currency . ' ' . round($get_price, 2);
        } else {

            if ($product_id != '') {
                $get_product  = Product::where('id', $product_id)
                    ->first();

                // $selling_price = $get_product->selling_price ?? 0;
                // $original_price = $get_product->original_price ?? 0;
                $pricing_type = '';



                $min_price_details  = ProductOptionPricingTiers::where(['product_option.product_id' => $product_id])
                    ->leftJoin('product_option', 'product_option.id', '=', 'product_option_pricing_tiers.option_id')
                    ->where('product_option.status', 'Active')
                    ->where('product_option_pricing_tiers.retail_price', '>', 0)->orderBy('product_option_pricing_tiers.retail_price', 'asc')->first();
                // $min_price_details  =  ProductOptionPricingTiers::where(['product_id' => $product_id])->where('retail_price', '>=', 0)->orderBy('retail_price', 'asc')->first();

                $max_price_details  = ProductOptionPricingTiers::where(['product_id' => $product_id])->where('retail_price', '>=', 0)->orderBy('retail_price', 'desc')->first();
                $percentage = 0;
                if ($min_price_details) {
                    $fulldate   = Carbon::now()->toDateString();
                    $date   = Carbon::parse($fulldate)->format('Y-m-d');
                    $fullday =  Carbon::parse($fulldate)->format('l');
                    $day  = Str::lower(substr($fullday, 0, 3));
                    // dd($min_price_details);
                    $ProductOptionDiscount = ProductOptionDiscount::where(['product_id' => $min_price_details->product_id, 'pricing_id' => $min_price_details->pricing_id, 'option_id' => $min_price_details->option_id])->where('valid_from', '<=', $date)->where('valid_to', '>=', $date)->first();

                    // dd($ProductOptionDiscount);
                    if ($ProductOptionDiscount) {
                        $percentage = $ProductOptionDiscount->date_percentage;

                        // Weekdays Percentage
                        if ($ProductOptionDiscount->time_json != "") {
                            $time_json = json_decode($ProductOptionDiscount->time_json);
                            foreach ($time_json as $TJkey => $TJ) {
                                if ($TJkey == $day) {
                                    if ($TJ > 0 && $TJ != "") {
                                        $percentage = $TJ;
                                    }
                                }
                            }
                        }


                        // Date Percentage
                        if ($ProductOptionDiscount->date_json != "") {
                            $date_json = json_decode($ProductOptionDiscount->date_json);
                            foreach ($date_json as $DJkey => $DJ) {
                                if ($DJkey == $date) {
                                    if ($DJ > 0 && $DJ != "") {
                                        $percentage = $DJ;
                                    }
                                }
                            }
                        }
                    }


                    $ProductOptionPricing =  ProductOptionPricing::where(['product_id' => $product_id, 'id' => $min_price_details->pricing_id])->first();
                    if ($ProductOptionPricing) {
                        $pricing_type = $ProductOptionPricing->pricing_type;
                    }
                }

                $min_price =  ProductOptionPricingTiers::where(['product_option.product_id' => $product_id])
                    ->where('product_option_pricing_tiers.retail_price', '>', 0)
                    ->leftJoin('product_option', 'product_option.id', '=', 'product_option_pricing_tiers.option_id')

                    ->min('retail_price');

                // ProductOptionPricingTiers::where(['product_id' => $product_id])->min('retail_price');
                $max_price = ProductOptionPricingTiers::where(['product_id' => $product_id])->max('retail_price');
                if ($min_price == "") {
                    $min_price = 0;
                }
                $discountAmount = $min_price;

                if ($percentage > 0 && $min_price > 0 && is_numeric($min_price) && is_numeric($percentage)) {

                    $percentageAmount = ($min_price * $percentage) / 100;
                    $discountAmount  = $min_price - $percentageAmount;
                }

                if ($pricing_type != "") {
                    $pricing_type = 'Per ' . ucfirst($pricing_type);
                }


                if ($get_product) {
                    if ($type == 'details') {
                        // dd($percentage, $min_price);
                        $html .=
                            '<div class="price_amount">
                        <p> 
                        <span class="symbol_icon">' . $currency . '</span> ' . round($discountAmount, 2) . ' </p>';
                        if ($percentage > 0 && $min_price > 0) {
                            $html .=  '<span class="saving_price">' . $currency . ' ' . round($min_price, 2) . '</span>';
                        }

                        $html .=  '</div>
                    <p class="per_person">' . $pricing_type . '</p>';
                        // <span class="saving_price">$550</span>

                        // <p> <span class="symbol_icon">' . $currency . '</span> ' . $min_price . ' </p>

                    } else {
                        $html .=
                            '<p><span>';
                        if ($percentage > 0 && $min_price > 0) {
                            $html .=   $currency . ' ' . $min_price;
                        }


                        $html .= '</span><span class="price_icon">' . $currency . '</span> ' . round($discountAmount, 2) . '</p>
                    <p>' . $pricing_type . '</p>';
                    }
                }
                if ($only_price == 1) {
                    return round($discountAmount, 2);
                } else {

                    return $html;
                }
            }
        }
    }
}

if (!function_exists('thumbnail_images')) {
    function thumbnail_images($image, $new_name, $setwidth, $setheight)
    {
        $destinationPath = public_path('uploads/all_thumbnails/');


        $imgFile         = Image::make($image->path());
        $height          = $imgFile->height();
        $width           = $imgFile->width();
        $imgFile->resize($setwidth, $setheight, function ($constraint) {
            $constraint->aspectRatio();
        });

        $imgFile->save($destinationPath . '/' . $new_name);

        return $new_name;
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

// GENERATE pRODUCT lINK
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
                return '';
            }
        } else {
            return '';
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
                // $get_random_review = DB::table('products')
                //     ->where(['id' => $product_id])
                //     ->first();
                // if ($get_random_review) {
                //     $random_review = $get_random_review->random_rating;
                // }
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
                    $color = 'rgb(252 83 1)';
                } elseif ($value == 4) {
                    $color = 'rgb(252 83 1)';
                } elseif ($value == 3) {
                    $color = 'rgb(252 83 1)';
                } elseif ($value == 2) {
                    $color = 'rgb(252 83 1)';
                } else {
                    $color = 'rgb(252 83 1)';
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


if (!function_exists('SendProductUploadMail')) {
    function SendProductUploadMail($data, $Product)
    {

        if ($Product != "") {
            if ($Product->for_approvel == '1') {
                $data['subject']     = 'Product Upload';

                Mail::send($data['page'], $data, function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['subject']);
                });
            } else if ($Product->for_approvel == '2' && $Product->is_approved == "Approved") {
                $data['subject']     = 'Product Upload';

                Mail::send($data['page'], $data, function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['subject']);
                });
            }
        }
    }
}
if (!function_exists('objectToArray')) {

    function objectToArray($d)
    {

        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
            return array_map(__FUNCTION__, $d);
        } else {
            // Return array
            return $d;
        }
    }
}

if (!function_exists('goPreviousUrl')) {

    function goPreviousUrl()
    {
        return Session::get('previous_session_url');
    }
}


if (!function_exists('getWeatherDetails')) {
    function getWeatherDetails($location)
    {
        $WEATHER_KEY = env('WEATHER_KEY');
        $location = urlencode($location);

        $response = '';
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'http://api.weatherapi.com/v1/forecast.json?key=' . $WEATHER_KEY . '&q=' . $location,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
        ]);

        if (curl_exec($curl) === false) {
        } else {
            $response = curl_exec($curl);
            $response = json_decode($response);
            if (isset($response->error)) {
                $response = '';
            }
        }

        curl_close($curl);

        return $response;
    }
}


if (!function_exists('getDateFilter')) {
    function getDateFilter($data, $order_orderDate)
    {
        $returnData = "";

        if (isset($data)) {
            $getordersDate = explode('to', $order_orderDate);
            $formdate = '';
            $todate = '';
            if (isset($getordersDate[0])) {
                $formdate = $getordersDate[0] . " 00:00:00";
                $data->whereDate('created_at', '>=', $formdate);
            }
            if (isset($getordersDate[1])) {
                $todate = $getordersDate[1] . " 23:59:59";
                $data->whereDate('created_at', '<=', $todate);
            }
            $returnData =  $data;
        }
        return $returnData;
    }
}
