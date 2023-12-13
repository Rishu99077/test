<?php

namespace App\Http\Controllers\RestaurantAdminController;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ExportProfitLoss;
use App\Models\ExpensesBillItem;
use App\Models\ExpensesCategory;
use App\Models\IngredientsPresentation;
use App\Models\Expenses;
use App\Models\Recipe;
use App\Models\RestaurantSetting;
use App\Models\PurchaseOrderItemsModel;
use App\Models\User;
use App\Models\Waste;
use App\Models\WasteItem;
use App\Models\WasteReason;
use App\Models\InventoryItem;
use App\Models\PriceChange;
use App\Models\InvoiceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

use Lang;
use App\Models\Inventory;

require_once __DIR__ . "../../../../../plugin/dompdf/autoload.inc.php";

use Dompdf\Dompdf;

class ReportController extends Controller
{
    public function profit_loss()
    {
        $restaurant_user_id = get_user_id();
        $common = array();
        $common['heading_title'] = Lang::get("restaurant.text_profit_loss_report");
        $common['main_menu'] = 'reports';
        $common['sub_menu'] = 'profitloss';

        $expenses =  Expenses::where(ConditionQuery())->orderBy("id", "DESC")->take(10)->get();
        $all_expenses_category = ExpensesCategory::where('status', 1)->where("parent", 0)->where(ConditionQuery())->get();
        @$date_range = $_GET['date_range'];
        $get_exp_category = [];
        $parentCat = [];
        $parentCatName = [];
        foreach ($all_expenses_category as $key => $cate) {

            $week_Expenses = Expenses::where('category', $cate->id)->where(ConditionQuery());
            $year_Expenses = Expenses::where('category', $cate->id)->where(ConditionQuery());
            if (isset($date_range) && $date_range != null) {
                $date       = explode("-", $date_range);
                $start_date = date("Y-m-d", strtotime($date[0]));
                $end_date   =  date("Y-m-d", strtotime($date[1]));

                $week_Expenses = $week_Expenses->where('date', ">=", $start_date)->where('date', "<=", $end_date);
                $year_Expenses = $year_Expenses->where('date', ">=", $start_date)->where('date', "<=", $end_date);
            } else {
                $week_Expenses = $week_Expenses->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                $year_Expenses = $year_Expenses->whereBetween('date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);
            }


            $weekly_exp = [];
            $yearly_exp = [];
            $weekly_exp[] = $cat_week_Expenses =  $week_Expenses->sum('total');
            $yearly_exp[] = $cat_year_Expenses = $year_Expenses->sum('total');



            $get_sub_category = ExpensesCategory::where("parent", $cate->id)->where('status', 1)->where(ConditionQuery())->get();
            foreach ($get_sub_category as $key => $sub_cat) {
                $week_exp = Expenses::where('category', $sub_cat->id)->where(ConditionQuery())->where('is_deleted', 0);
                $year_exp = Expenses::where('category', $sub_cat->id)->where(ConditionQuery())->where('is_deleted', 0);
                if (isset($date_range) && $date_range != null) {
                    $date = explode("-", $date_range);
                    $start_date = date("Y-m-d", strtotime($date[0]));
                    $end_date =  date("Y-m-d", strtotime($date[1]));
                    $week_exp = $week_exp->where('date', ">=", $start_date)->where('date', "<=", $end_date);
                } else {
                    $week_exp = $week_exp->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                }
                $year_exp = $year_exp->whereBetween('date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);

                $weekly_exp[]  = $week_exp->sum('total');
                $yearly_exp[]  = $year_exp->sum('total');
            }

            $cate_exp['weekly_exp'] = array_sum($weekly_exp);
            $cate_exp['yearly_exp'] = array_sum($yearly_exp);
            $cate_exp['cat_week_Expenses'] = $cat_week_Expenses;
            $cate_exp['cat_year_Expenses'] = $cat_year_Expenses;
            $cate_exp['image'] =  $cate->image;
            $cate_exp['name'] =  $cate->name;
            $cate_exp['id'] =  $cate->id;
            $get_exp_category[] = $cate_exp;
        }

        return view("restaurant.reports.profit_loss", compact('common', 'get_exp_category'));
    }

    public function menu_engineering(Request $request)
    {
        $restaurant_user_id      = get_user_id();
        $common                  = array();
        $common['heading_title'] = Lang::get("restaurant.text_menu_engineering");

        $common['main_menu']    = 'reports';
        $common['sub_menu']     = 'menu_engi';
        $recipe = Recipe::where(ConditionQuery());
        if (isset($request->name) || isset($request->date_range)) {
            if ($request->name != "") {
                $recipe = $recipe->where("name", 'like', "%" . $request->name . "%");
            }
            if ($request->date_range != "") {
                $date   = explode("-", $request->date_range);
                $date1  = date("Y-m-d H:i:s", strtotime($date[0] . ' -1 day'));
                $date2  = date("Y-m-d H:i:s", strtotime($date[1] . ' +1 day'));
                $recipe = $recipe->whereBetween("created_at", [$date1, $date2]);
            }
        }
        $recipe = $recipe->get();
        return view("restaurant.reports.menu_engineering", compact('common', 'recipe'));
    }


    public function menu_matriz_export(Request $request)
    {

        $fileName = 'Menu-Matriz-' . time() . '.csv';
        $restaurant_user_id = get_user_id();
        $recipe = Recipe::where(ConditionQuery());
        if (isset($request->name_filter) || isset($request->date_range_filter)) {
            if ($request->name_filter != "") {
                $recipe = $recipe->where("name", 'like', "%" . $request->name_filter . "%");
            }
            if ($request->date_range_filter != "") {
                $date = explode("-", $request->date_range_filter);
                $date1 = date("Y-m-d H:i:s", strtotime($date[0] . ' -1 day'));
                $date2 = date("Y-m-d H:i:s", strtotime($date[1] . ' +1 day'));
                $recipe = $recipe->whereBetween("created_at", [$date1, $date2]);
            }
        }
        $recipe = $recipe->get();

        ///////////EXCEL
        if ($request->excel) {
            $restaurant_target = RestaurantSetting::where('restaurant_user_id', get_user_id())
                ->where('meta_key', 'restaurant_target')
                ->first();
            $restaurant_target_with_iva = RestaurantSetting::where('restaurant_user_id', get_user_id())
                ->where('meta_key', 'restaurant_target_with_iva')
                ->first();
            if ($restaurant_target != '') {
                $tar = $restaurant_target->meta_value;
            } else {
                $tar = '';
            }
            if ($restaurant_target_with_iva != '') {
                $tariva = $restaurant_target_with_iva->meta_value;
            } else {
                $tariva = '';
            }
            $totalSold = 0;
            $totalContribution = 0;
            $recipe_count = count($recipe);
            if ($recipe_count > 0) {
                foreach ($recipe as $key => $R) {
                    $key = $key + 1;
                    $s = 100 * $key;
                    $totalSold += $s;
                    $total_dish_cost = $R['total_dish_cost'];
                    $selling_price = $R['selling_price'];
                    $total_cost = $total_dish_cost * $s;
                    $total_revenue = $selling_price * $s;
                    $totalContribution += $total_revenue - $total_cost;
                }
                $avg_item_profit = $totalContribution / $totalSold;
                $menu_popularity_fac = (1 / $recipe_count) * 0.8;
            }
            ////////
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0",
            );
            $columns = array(
                __("restaurant.text_sno"), __("restaurant.text_menu_item_name"), __("restaurant.text_number_sold"),
                __("restaurant.text_popularity_per") . ' %', __("restaurant.text_item_food_cost_no_tax"), __("restaurant.text_item_sell_price_no_tax"), __("restaurant.text_item_sell_price_tax"), __("restaurant.text_suggested_sale_price"), __("restaurant.text_suggested_sale_price_tax"), __("restaurant.text_ideal_cost") . ' %', __("restaurant.text_item_contribution"), __("restaurant.text_total_cost"), __("restaurant.text_total_revenue"), __("restaurant.text_total_contribuation"), __("restaurant.text_profit_category"), __("restaurant.text_popularity_category"), __("restaurant.text_menu_item_class"),
            );

            $callback = function () use ($recipe, $columns, $totalSold, $tariva, $tar, $avg_item_profit, $menu_popularity_fac) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                foreach ($recipe as $key => $task) {
                    if ($tar != '') {
                        $SSP = ($task->total_dish_cost / $tar) * 100;
                    }
                    if ($tariva != '' && $tar != '') {
                        $SSPT = "$" . number_format($SSP * $tariva, 2);
                    } else {
                        $SSPT = " ";
                    }
                    $row[__("restaurant.text_sno")] = $key + 1;
                    $row[__("restaurant.text_menu_item_name")] = $task->name;
                    $sold = $row[__("restaurant.text_number_sold")] = 100 * ($key + 1);
                    $row[__("restaurant.text_popularity_per") . ' %'] = number_format($pop = ($sold / $totalSold) * 100, 2) . "%";
                    $row[__("restaurant.text_item_food_cost_no_tax")] = "$" . $total_dish_cost = $task->total_dish_cost;
                    $row[__("restaurant.text_item_sell_price_no_tax")] = "$" . $selling_price = $task->selling_price;
                    $row[__("restaurant.text_item_sell_price_tax")] = $tariva != "" ? "$" . $task->selling_price * $tariva : "";
                    $row[__("restaurant.text_suggested_sale_price")] = $tar != "" ? "$" . number_format(($total_dish_cost / $tar) * 100, 2) : "";
                    $row[__("restaurant.text_suggested_sale_price_tax")] = $SSPT;
                    $row[__("restaurant.text_ideal_cost") . ' %'] = $task->food_cost_budgeted_percenatge . "%";
                    $row[__("restaurant.text_item_contribution")] = "$" . $contribution = $selling_price - $total_dish_cost;
                    $row[__("restaurant.text_total_cost")] = "$" . number_format($total_cost = $total_dish_cost * $sold, 2);
                    $row[__("restaurant.text_total_revenue")] = "$" . number_format($total_revenue = $selling_price * $sold, 2);
                    $row[__("restaurant.text_total_contribuation")] = number_format($total_revenue - $total_cost, 2);
                    $profit_category = $row[__("restaurant.text_profit_category")] = $contribution < $avg_item_profit ? 'LOW' : 'HIGH';
                    $popuCatgory = $row[__("restaurant.text_popularity_category")] = $pop < $menu_popularity_fac ? 'LOW' : 'HIGH';
                    if ($profit_category == 'LOW' && $popuCatgory == 'LOW') {
                        $MIC = 'Dog';
                    } elseif ($profit_category == 'LOW' && $popuCatgory == 'HIGH') {
                        $MIC = 'Workhorse';
                    } elseif ($profit_category == 'HIGH' && $popuCatgory == 'LOW') {
                        $MIC = 'Challenge';
                    } else {
                        $MIC = 'Star';
                    }
                    $row[__("restaurant.text_menu_item_class")] = $MIC;
                    fputcsv($file, array(
                        $row[__("restaurant.text_sno")],
                        $row[__("restaurant.text_menu_item_name")],
                        $row[__("restaurant.text_number_sold")],
                        $row[__("restaurant.text_popularity_per") . ' %'],
                        $row[__("restaurant.text_item_food_cost_no_tax")],
                        $row[__("restaurant.text_item_sell_price_no_tax")],
                        $row[__("restaurant.text_item_sell_price_tax")],
                        $row[__("restaurant.text_suggested_sale_price")],
                        $row[__("restaurant.text_suggested_sale_price_tax")],
                        $row[__("restaurant.text_ideal_cost") . ' %'],
                        $row[__("restaurant.text_item_contribution")],
                        $row[__("restaurant.text_total_cost")],
                        $row[__("restaurant.text_total_revenue")],
                        $row[__("restaurant.text_total_contribuation")],
                        $row[__("restaurant.text_profit_category")],
                        $row[__("restaurant.text_popularity_category")],
                        $row[__("restaurant.text_menu_item_class")],
                    ));
                }
                fclose($file);
            };
            return response()->stream($callback, 200, $headers);
        } else {

            $dompdf   = new Dompdf();
            $viewhtml = View::make("pdf.pdf_menu_engineering", compact('recipe'))->render();

            // return $viewhtml;
            $dompdf->loadHtml($viewhtml);
            $options = $dompdf->getOptions();
            $options->set(array('isRemoteEnabled' => true));
            $options->set('isPhpEnabled', true);
            $dompdf->setOptions($options);
            $dompdf->set_paper('A4', 'landscape');
            $dompdf->render();
            $pdf = $dompdf->output();
            $dompdf->stream(
                "Menu-Engineering",
                array('Attachment' => 1)
            );
        }
    }

    public function waste(Request $request)
    {
        $restaurant_user_id = get_user_id();
        $common = array();
        $common['heading_title'] = Lang::get("restaurant.text_waste_report");
        $common['main_menu'] = 'reports';
        $common['sub_menu'] = 'waste_report';
        $value = "";
        if ($request->ajax()) {
            $value = $request->value;
            if ($value == "date" || $value == "custom_date") {
                if ($value == "custom_date") {
                    $custom_date = $request->subvalue;
                    $date = explode("-", $custom_date);

                    $start =  Carbon::parse($date[0]);
                    $end   =  Carbon::parse($date[1]);
                } else {

                    $start = Carbon::now()->startOfMonth();
                    $end = Carbon::now()->endOfMonth();
                }

                $waste_data = [];
                $waste = [];
                $waste_final_arr = [];

                for ($i = $start; $i <= $end; $i->modify('+1 day')) {
                    $waste_data = Waste::where(ConditionQuery("", "wastes."))->whereDate("wastes.date", $i->format('Y-m-d'))
                        ->join('waste_items', "wastes.id", "=", "waste_items.waste_id")
                        ->get();
                    $waste_data_amount_total = Waste::where(ConditionQuery("", "wastes."))->whereDate("wastes.date", $i->format('Y-m-d'))
                        ->join('waste_items', "wastes.id", "=", "waste_items.waste_id")->sum('amount');
                    $waste_drilldown = [];
                    $amount = 0;
                    $total  = 0;
                    $totalWaste = 0;
                    $product_id = array();


                    if (count($waste_data) > 0) {
                        foreach ($waste_data as $key => $W) {
                            $category = 0;
                            $name = "";
                            $amount = 0;
                            if ($W['waste_type'] == "Presentation") {
                                $presentation = IngredientsPresentation::find($W['product_id']);
                                if ($presentation != "") {
                                    $category = $presentation->category;
                                }
                            }
                            $category_detail = Category::find($category);
                            if ($category_detail != "") {
                                $name = $category_detail->name;
                            }
                            if ($category) {
                                $waste_arr['name']      = $i->format('Y-m-d');
                                $waste_arr['y']         = (int) $waste_data_amount_total;
                                $waste_arr['drilldown'] = $i->format('Y-m-d');
                                $totalWaste             = $totalWaste + $waste_data_amount_total;
                                $product_id[]           = $W['product_id'];
                            } else {
                                $waste_arr['name']           = $i->format('Y-m-d');
                                $waste_arr['y']              = 0;
                                $totalWaste                  = 0;
                                $waste_arr['drilldown']      = $i->format('Y-m-d');
                                $product_id[]                = $W['product_id'];
                            }
                        }
                    } else {
                        $waste_arr['name']      = $i->format('Y-m-d');
                        $waste_arr['y']         = 0;
                        $totalWaste             = 0;
                        $waste_arr['drilldown'] = $i->format('Y-m-d');
                        $product_id[]           = "";
                    }



                    $totalPurchaseWaste = 0;
                    $getPurchaseOrderItemsModel = PurchaseOrderItemsModel::whereIn('description', $product_id)->groupBy('purchase_id')->get();
                    foreach ($getPurchaseOrderItemsModel as $key => $get_purchase_value) {
                        // code...
                        $InvoiceModel = InvoiceModel::where(ConditionQuery())->where('purchase_id', $get_purchase_value->purchase_id)->where('status', 'settled')->first();
                        if ($InvoiceModel) {
                            $totalPurchaseWaste  += $InvoiceModel['invoice_amount'];
                        }
                    }
                    $total_percent = 0;
                    if ($totalWaste != 0 && $totalPurchaseWaste != 0) {
                        $total_percent = $totalWaste /  $totalPurchaseWaste;
                    }

                    $waste_final_arr['totalWaste']         = number_format($totalWaste, 2);
                    $waste_final_arr['totalPurchaseWaste'] = number_format($totalPurchaseWaste, 2);
                    $waste_final_arr['total_percent']      = number_format($total_percent, 2);
                    $waste_final_arr['waste'][]            = $waste_arr;
                }
                // $temp = array_unique(array_column($waste_final_arr, 'name'));
                ///Total Purchase

                return $waste = json_encode($waste_final_arr);
            }


            if ($value == "week") {

                $weekdates = $this->getWeek();

                $waste_data = [];
                $waste = [];
                $waste_final_arr = [];

                foreach ($weekdates as $key => $WD) {

                    $dates = explode("-", $WD);

                    $start_date = date("Y-m-d", strtotime($dates[0]));
                    $end_date = date("Y-m-d", strtotime($dates[1]));

                    $waste_data =
                        Waste::where(ConditionQuery("", "wastes."))->whereDate("wastes.date", ">=", $start_date)->whereDate("wastes.date", "<=", $end_date)
                        ->join('waste_items', "wastes.id", "=", "waste_items.waste_id")
                        ->get();


                    $waste_data_amount_total =  Waste::where(ConditionQuery("", "wastes."))->whereDate("wastes.date", ">=", $start_date)->whereDate("wastes.date", "<=", $end_date)
                        ->join('waste_items', "wastes.id", "=", "waste_items.waste_id")->sum('amount');
                    $waste_drilldown = [];
                    $amount = 0;
                    $totalWaste = 0;
                    $product_id = array();
                    $start_date = date("Y/m/d", strtotime($dates[0]));
                    $end_date = date("Y/m/d", strtotime($dates[1]));
                    if (count($waste_data) > 0) {

                        foreach ($waste_data as $key => $W) {

                            $category = 0;
                            $name = "";
                            $amount = 0;
                            if ($W['waste_type'] == "Presentation") {
                                $presentation = IngredientsPresentation::find($W['product_id']);
                                if ($presentation != "") {

                                    $category = $presentation->category;
                                }
                            }
                            $category_detail = Category::find($category);
                            if ($category_detail != "") {
                                $name = $category_detail->name;
                            }
                            if ($category) {
                                $waste_arr['name']      = $start_date . "-" . $end_date;
                                $waste_arr['y']         = (int) $waste_data_amount_total;
                                $waste_arr['drilldown'] = $start_date . "-" . $end_date;
                                $totalWaste             = $totalWaste + $waste_data_amount_total;
                                $product_id[]           = $W['product_id'];
                            } else {
                                $waste_arr['name']      = $start_date . "-" . $end_date;
                                $waste_arr['y']         = 0;
                                $waste_arr['drilldown'] = $start_date . "-" . $end_date;
                                $totalWaste             = 0;
                                $product_id[]           = $W['product_id'];
                            }
                        }
                    } else {
                        $waste_arr['name']      = $start_date . "-" . $end_date;
                        $waste_arr['y']         = 0;
                        $waste_arr['drilldown'] = $start_date . "-" . $end_date;
                        $totalWaste             = 0;
                        $product_id[]           = "";
                    }

                    $totalPurchaseWaste = 0;
                    $getPurchaseOrderItemsModel = PurchaseOrderItemsModel::whereIn('description', $product_id)->groupBy('purchase_id')->get();
                    foreach ($getPurchaseOrderItemsModel as $key => $get_purchase_value) {
                        // code...
                        $InvoiceModel = InvoiceModel::where(ConditionQuery())->where('purchase_id', $get_purchase_value->purchase_id)->where('status', 'settled')->first();
                        if ($InvoiceModel) {
                            $totalPurchaseWaste  += $InvoiceModel['invoice_amount'];
                        }
                    }
                    $total_percent = 0;
                    if ($totalWaste != 0 && $totalPurchaseWaste != 0) {
                        $total_percent = $totalWaste /  $totalPurchaseWaste;
                    }

                    $waste_final_arr['totalWaste']         =  number_format($totalWaste, 2);
                    $waste_final_arr['totalPurchaseWaste'] =  number_format($totalPurchaseWaste, 2);
                    $waste_final_arr['total_percent']      =  number_format($total_percent, 2);
                    $waste_final_arr['waste'][]    = $waste_arr;
                }

                return $waste = json_encode($waste_final_arr);
            }


            if ($value == "category") {
                $waste_data =
                    Waste::where(ConditionQuery("", "wastes."))
                    ->join('waste_items', "wastes.id", "=", "waste_items.waste_id")
                    ->orderBy("wastes.id", "DESC")->get();
                $waste = [];
                $waste_drilldown = [];
                $amount = 0;
                $categoryArr = [];
                $totalWaste  = 0;
                $product_id  = array();
                // dd($waste_data);
                foreach ($waste_data as $key => $W) {
                    $category = 0;
                    $name = "";
                    $amount = 0;
                    if ($W['waste_type'] == "Presentation") {
                        $product_id[]      = $W['product_id'];
                        $presentation = IngredientsPresentation::find($W['product_id']);
                        $amount = WasteItem::where("product_id", $W['product_id'])->sum('amount');
                        if ($presentation != "") {
                            $cat[] =  $category = $presentation->category;
                        }
                    }

                    $category_detail = Category::find($category);
                    if ($category_detail != "") {
                        $name = $category_detail->name;
                    }
                    if ($category) {

                        $reason = WasteReason::find($W['waste_reason']);
                        $totalWaste             = $totalWaste + $amount;
                        if ($request->subvalue == "by_reason") {

                            $waste_arr['id'] = $W['id'];
                            $waste_arr['name'] = $reason->title;
                            $waste_arr['data'] = [(int) $amount];
                            $waste_arr['stack'] = $name;
                            $cat['name'] = $name;
                        } else {
                            $waste_arr['name']      = $name;
                            $waste_arr['y']         = (int) $amount;
                            $waste_arr['drilldown'] = $name;
                        }
                        $waste[] = $waste_arr;
                        $categoryArr[] = $cat;
                    }
                }
                $totalPurchaseWaste = 0;
                $getPurchaseOrderItemsModel = PurchaseOrderItemsModel::whereIn('description', $product_id)->groupBy('purchase_id')->get();
                foreach ($getPurchaseOrderItemsModel as $key => $get_purchase_value) {
                    // code...
                    $InvoiceModel = InvoiceModel::where(ConditionQuery())->where('purchase_id', $get_purchase_value->purchase_id)->where('status', 'settled')->first();
                    if ($InvoiceModel) {
                        $totalPurchaseWaste  += $InvoiceModel['invoice_amount'];
                    }
                }


                if ($request->subvalue == "by_reason") {
                    $waste = json_encode($waste);
                } else {
                    $temp  = array_unique(array_column($waste, 'name'));
                    $waste = json_encode($waste);
                }

                $total_percent = 0;
                if ($totalWaste != 0 && $totalPurchaseWaste != 0) {
                    $total_percent = $totalWaste /  $totalPurchaseWaste;
                }

                $temp1    = array_unique(array_column($categoryArr, 'name'));
                $category = json_encode($temp1);
                return [
                    'totalWaste'          => number_format($totalWaste, 2),
                    'totalPurchaseWaste'  => number_format($totalPurchaseWaste, 2),
                    'total_percent'       => number_format($total_percent, 2),
                    'waste'               => $waste,
                    'category'            => $category,
                    'stacking'             => "normal",
                ];
            }

            if ($value == "reason") {

                $getwaste = [];
                $waste = [];
                $waste_drilldown = [];
                $amount = 0;
                $totalWaste = 0;
                $product_id = array();

                $categoryArr = [];
                $waste_reason = WasteReason::where(ConditionQuery())->where('status', 1)

                    ->get();

                foreach ($waste_reason as $WR) {
                    $amount  = WasteItem::where(ConditionQuery("all"))->where('waste_reason', $WR['id'])->sum("amount");

                    $waste_arr['name'] = $WR['title'];
                    $waste_arr['y'] = (int) $amount;
                    $waste_arr['drilldown'] =  $WR['title'];
                    $product_id[]      = $WR['product_id'];
                    $totalWaste     = $totalWaste + (int) $amount;

                    $waste[] = $waste_arr;
                }

                $totalPurchaseWaste = 0;
                $getPurchaseOrderItemsModel = PurchaseOrderItemsModel::whereIn('description', $product_id)->groupBy('purchase_id')->get();
                foreach ($getPurchaseOrderItemsModel as $key => $get_purchase_value) {
                    // code...
                    $InvoiceModel = InvoiceModel::where(ConditionQuery())->where('purchase_id', $get_purchase_value->purchase_id)->where('status', 'settled')->first();
                    if ($InvoiceModel) {
                        $totalPurchaseWaste  += $InvoiceModel['invoice_amount'];
                    }
                }
                $total_percent = 0;
                if ($totalWaste != 0 && $totalPurchaseWaste != 0) {
                    $total_percent = $totalWaste /  $totalPurchaseWaste;
                }
                $getwaste['waste']              = $waste;
                $getwaste['totalWaste']         = number_format($totalWaste, 2);
                $getwaste['totalPurchaseWaste'] = number_format($totalPurchaseWaste, 2);
                $getwaste['total_percent']      = number_format($total_percent, 2);
                return json_encode($getwaste);
            }
        }

        $waste_data = Waste::where(ConditionQuery("", "wastes."))
            ->join('waste_items', "wastes.id", "=", "waste_items.waste_id")->orderBy("wastes.id", "DESC")->get();
        $waste              = [];
        $waste_drilldown    = [];
        $amount             = 0;
        $product_id         = array();
        $totalWaste         = 0;
        foreach ($waste_data as $key => $W) {
            $category = 0;
            $name = "";
            $amount = 0;


            if ($W['waste_type'] == "Presentation") {
                $product_id[]  = $W['product_id'];
                $presentation  = IngredientsPresentation::find($W['product_id']);
                $amount = WasteItem::where("product_id", $W['product_id'])->sum('amount');
                if ($presentation != "") {

                    $category = $presentation->category;
                }
            }


            $category_detail = Category::find($category);
            if ($category_detail != "") {
                $name = $category_detail->name;
            }
            if ($category) {
                $totalWaste = $totalWaste + $amount;
                $waste_arr['name'] = $name;
                $waste_arr['y'] = (int) $amount;
                $waste_arr['drilldown'] = $name;
                $waste[] = $waste_arr;
            }
        }
        ///Total Purchase
        $totalPurchaseWaste = 0;
        $getPurchaseOrderItemsModel = PurchaseOrderItemsModel::whereIn('description', $product_id)->groupBy('purchase_id')->get();
        foreach ($getPurchaseOrderItemsModel as $key => $get_purchase_value) {
            // code...
            $InvoiceModel = InvoiceModel::where(ConditionQuery())->where('purchase_id', $get_purchase_value->purchase_id)->where('status', 'settled')->first();
            if ($InvoiceModel) {
                $totalPurchaseWaste  += $InvoiceModel['invoice_amount'];
            }
        }
        $total_percent = 0;
        if ($totalWaste != 0 && $totalPurchaseWaste != 0) {
            $total_percent = number_format($totalWaste /  $totalPurchaseWaste, 2);
        }
        $temp  = array_unique(array_column($waste, 'name'));
        $waste = json_encode($waste);
        return view("restaurant.reports.waste_report", compact('common', 'waste', 'totalWaste', 'totalPurchaseWaste', 'total_percent'));
    }

    public function getWeek()
    {

        $today = Carbon::today();
        $date = $today->copy()->firstOfMonth()->startOfDay();
        $eom = $today->copy()->endOfMonth()->startOfDay();

        $dates = [];

        for ($i = 1; $date->lte($eom); $i++) {
            $startDate = $date->copy();
            while ($date->dayOfWeek != Carbon::SUNDAY && $date->lte($eom)) {
                $date->addDay();
            }
            $dates['w' . $i] = $startDate->format('Y/m/d') . ' - ' . $date->format('Y/m/d');
            $date->addDay();
        }

        return $dates;
    }

    public function inventory()
    {
        $restaurant_user_id = get_user_id();
        $common = array();
        $common['heading_title'] = Lang::get("restaurant.text_inventory_report");
        $common['main_menu'] = 'reports';
        $common['sub_menu'] = 'inventory_report';
        @$filter_date = $_GET['date_range'];
        @$filter_by = $_GET['filter_by'];

        $inventory = Inventory::where(ConditionQuery());
        if ($filter_date != '') {
            $date = explode("-", $filter_date);
            $start_date = date("Y-m-d", strtotime(trim($date[0])));
            $end_date =  date("Y-m-d", strtotime(trim($date[1])));
            $inventory = $inventory->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date);
        }
        if ($filter_by != "") {
            if ($filter_by == "by_date") {
                $inventory = $inventory->groupBy(DB::raw('Date(date)'));
            }
        }

        $inventory = $inventory->orderBy("id", "DESC")->get();

        return view('restaurant.reports.inventory_report', compact('inventory', 'common', 'filter_by'));
    }

    public function inventory_volume()
    {
        $restaurant_user_id = get_user_id();
        $common = array();
        $common['heading_title'] = Lang::get("restaurant.text_inventory_report");
        $common['main_menu'] = 'reports';
        $common['sub_menu'] = 'inventory_volume';
        @$filter_date = $_GET['date_range'];
        @$filter_by = $_GET['filter_by'];

        $inventory = Inventory::where(ConditionQuery());
        if ($filter_date != '') {
            $date = explode("-", $filter_date);
            $start_date = date("Y-m-d", strtotime(trim($date[0])));
            $end_date =  date("Y-m-d", strtotime(trim($date[1])));
            $inventory = $inventory->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date);
        }
        if ($filter_by != "") {
            if ($filter_by == "by_date") {
                $inventory = $inventory->groupBy(DB::raw('Date(date)'));
            }
        }

        $inventory = $inventory->orderBy("id", "DESC")->groupBy(DB::raw('Date(date)'))->get();

        return view('restaurant.reports.inventory_volume_report', compact('inventory', 'common', 'filter_by'));
    }

    public function viewInventory(Request $request, $InventoryID)
    {
        $restaurant_user_id = get_user_id();
        $common = array();
        $common['heading_title'] = Lang::get("restaurant.text_inventory_report");
        $common['main_menu'] = 'reports';
        $common['sub_menu'] = 'inventory_report';
        $InventoryItems = InventoryItem::where(['restaurant_user_id' => $restaurant_user_id, 'inventory_id' => $InventoryID])->get();
        $ingredients_presentation = "";
        foreach ($InventoryItems as $val) {
            $ingredients_presentation = IngredientsPresentation::select('unique_code_name', 'group_base_name')->where(["restaurant_user_id" => $restaurant_user_id, "id" => $val['presentation_id']])->first();
        }

        $activeInventoryItem = InventoryItem::where(['restaurant_user_id' => $restaurant_user_id, 'inventory_id' => $InventoryID, 'is_last' => '1'])->first();
        return view('restaurant.reports.view_inventory_report', compact('ingredients_presentation', 'activeInventoryItem', 'InventoryItems', 'common'));
    }

    public function viewInventorybydate(Request $request, $InventoryID)
    {
        $restaurant_user_id = get_user_id();
        $InventoryID = decrypt($InventoryID);
        $Inventory = Inventory::where(['inventory.restaurant_user_id' => $restaurant_user_id, 'inventory.id' => $InventoryID])->first();
        $common = array();
        $common['heading_title'] = Lang::get("restaurant.text_inventory_report");
        $common['main_menu'] = 'reports';
        $common['sub_menu'] = 'inventory_report';
        $InventoryItems = Inventory::select('inventory.*', 'inventory_item.*', 'ingredients_presentation.group_base_name', 'category_group_base.group_base')->where(ConditionQuery("", "inventory."))->whereDate("date", date("Y-m-d", strtotime($Inventory->date)))
            ->join('inventory_item', 'inventory_item.inventory_id', '=', 'inventory.id')
            ->leftJoin('ingredients_presentation', 'ingredients_presentation.id', '=', 'inventory_item.presentation_id')
            ->leftJoin('category_group_base', 'category_group_base.id', '=', 'ingredients_presentation.group_base_name')
            ->get();


        return view('restaurant.reports.view_inventory_report_by_date', compact('InventoryItems', 'common'));
    }

    public function viewInventoryVolumebydate(Request $request, $InventoryID)
    {
        $restaurant_user_id = get_user_id();
        $InventoryID = decrypt($InventoryID);
        $Inventory = Inventory::where(['inventory.restaurant_user_id' => $restaurant_user_id, 'inventory.id' => $InventoryID])->first();
        $common = array();
        $common['heading_title'] = Lang::get("restaurant.text_inventory_report");
        $common['main_menu'] = 'reports';
        $common['sub_menu'] = 'inventory_report';
        $InventoryItems = Inventory::select('inventory.*', 'inventory_item.*', 'ingredients_presentation.group_base_name', 'ingredients_presentation.unit_price as pre_each',  'ingredients_presentation.avg_unit_bulk_price as pre_bulk', 'ingredients_presentation.individual_price as pre_individual', 'category_group_base.group_base')->where(ConditionQuery("", "inventory."))->whereDate("date", date("Y-m-d", strtotime($Inventory->date)))
            ->join('inventory_item', 'inventory_item.inventory_id', '=', 'inventory.id')
            ->leftJoin('ingredients_presentation', 'ingredients_presentation.id', '=', 'inventory_item.presentation_id')
            ->leftJoin('category_group_base', 'category_group_base.id', '=', 'ingredients_presentation.group_base_name')
            ->get();


        return view('restaurant.reports.view_inventory_volume_report_by_date', compact('InventoryItems', 'common'));
    }

    public function price_change()
    {
        $common = array();
        $common['heading_title'] = Lang::get("restaurant.text_price_change");
        $common['main_menu'] = 'reports';
        $common['sub_menu'] = 'price_change';
        $priceChange = PriceChange::select("ingredients_price_change.*", "ingredients_presentation.unique_code_name", "supplier.name as supName")
            ->leftJoin("ingredients_presentation", "ingredients_presentation.id", "=", "ingredients_price_change.presentation_id")
            ->leftJoin('supplier', 'ingredients_price_change.supplier', "=", "supplier.id")
            ->where(ConditionQuery("", "ingredients_price_change."))
            ->get();
        return view('restaurant.reports.price_change', compact('priceChange', 'common'));
    }

    public function report_sales()
    {
        $restaurant_user_id = get_user_id();
        $common = array();
        $common['heading_title'] = Lang::get("restaurant.text_sales");
        $common['main_menu'] = 'reports';
        $common['sub_menu'] = 'sales';
        return view('restaurant.reports.sales', compact('common'));
    }

    public function export_profit_loss_excel(Request $request)
    {
        return Excel::download(new ExportProfitLoss($request), 'ExportProfitLoss.xlsx');
    }
}
