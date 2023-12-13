<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\Models\ProductCheckout;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;



class ReportController extends Controller
{
    public function reports(Request $request)
    {
        $common = array();
        Session::put("TopMenu", "Reports");
        Session::put("SubMenu", "Sales Report");
        $common['title']             = translate("Sales Report");

        $common['startDate']           = '';
        $common['endDate']             = '';

         //FILTER ORDER POST DATA
        if ($request->isMethod('post')) {
            if (isset($request->filter)) {
                Session::put('report_all', $request->get('All'));
                Session::put('report_id', $request->get('OrderID'));
                Session::put('report_name', $request->get('Name'));
                Session::put('report_email', $request->get('Email'));
                Session::put('report_date', $request->get('Order_date'));
            } elseif (isset($request->reset)) {
                Session::put('report_all', '');
                Session::put('report_id', '');
                Session::put('report_name', '');
                Session::put('report_email', '');
                Session::put('report_date', '');
            }
            return redirect()->route('admin.reports');
        }

        $report_all    = Session::get('report_all');
        $report_id     = Session::get('report_id');
        $report_name   = Session::get('report_name');
        $report_email  = Session::get('report_email');
        $report_date   = Session::get('report_date');

        $common['report_all']     = $report_all;
        $common['report_id']      = $report_id;
        $common['report_name']    = $report_name;
        $common['report_email']   = $report_email;
        $common['report_date']    = $report_date;

        $ProductCheckout = ProductCheckout::orderBy('id', 'desc');

        if ($report_all) {
            $ProductCheckout = $ProductCheckout->where('order_id', 'LIKE', '%' . $report_all . '%');
            $ProductCheckout = $ProductCheckout->orwhere('first_name', 'LIKE', '%' . $report_all . '%');
            $ProductCheckout = $ProductCheckout->orwhere('last_name', 'LIKE', '%' . $report_all . '%');
            $ProductCheckout = $ProductCheckout->orwhere('email', 'LIKE', '%' . $report_all . '%');
            $ProductCheckout = $ProductCheckout->orwhere('phone_number', 'LIKE', '%' . $report_all . '%');
        }

        if ($report_id) {
            $ProductCheckout = $ProductCheckout->where('order_id', $report_id);
        }

        if ($report_name) {
            $ProductCheckout = $ProductCheckout->where('first_name', 'LIKE', '%' . $report_name . '%');
            $ProductCheckout = $ProductCheckout->orwhere('last_name', 'LIKE', '%' . $report_name . '%');
        }

        if ($report_email) {
            $ProductCheckout = $ProductCheckout->where('email', 'LIKE', '%' . $report_email . '%');
        }

        if ($report_date) {
            $getordersDate = explode('to', $report_date);
            $formdate = '';
            $todate = '';
             if (isset($getordersDate[0])) {
                $formdate = $getordersDate[0]." 00:00:00";
             }
             if (isset($getordersDate[1])) {
                $todate = $getordersDate[1]." 23:59:59";
             }
             if ($formdate!='' AND $todate!='') {
                 $ProductCheckout->whereDate('created_at', '>=',$formdate);
                 $ProductCheckout->whereDate('created_at', '<=',$todate);
             }
        }
        $ProductCheckout = $ProductCheckout->where('status', 'Success');


        $get_orders = $ProductCheckout->paginate(config('adminconfig.records_per_page'));

        return view('admin.report.reports_list', compact('common', 'get_orders'));
    }


    public function best_seller_report(Request $request)
    {
        $common = array();
        Session::put("TopMenu", "Reports");
        Session::put("SubMenu", "Best Sellers Report");
        $common['title']             = translate("Best Sellers Report");

        $get_products = Product::select('products.*', 'product_language.description as title')
            ->where('products.is_delete', 0)
            ->leftjoin('product_language', 'products.id', '=', 'product_language.product_id')
            ->groupBy('products.id')
            ->where('products.sales_count', '!=', 0)
            ->orderBy('products.sales_count', 'desc');

        $get_products = $get_products->paginate(config('adminconfig.records_per_page'));

        return view('admin.report.best_seller_report', compact('common', 'get_products'));
    }

    public function upcoming_booking_report(Request $request)
    {
        $common = array();
        Session::put("TopMenu", "Reports");
        Session::put("SubMenu", "Upcoming Booking");
        $common['title']             = translate("Upcoming Booking Report");

         //FILTER ORDER POST DATA
        if ($request->isMethod('post')) {
            if (isset($request->filter)) {
                Session::put('upcoming_order_all', $request->get('All'));
                Session::put('upcoming_order_id', $request->get('OrderID'));
                Session::put('upcoming_order_name', $request->get('Name'));
                Session::put('upcoming_order_email', $request->get('Email'));
                Session::put('upcoming_order_status', $request->get('Status'));
                Session::put('upcoming_order_date', $request->get('Order_date'));
            } elseif (isset($request->reset)) {
                Session::put('upcoming_order_all', '');
                Session::put('upcoming_order_id', '');
                Session::put('upcoming_order_name', '');
                Session::put('upcoming_order_email', '');
                Session::put('upcoming_order_status', '');
                Session::put('upcoming_order_date', '');
            }
            return redirect()->route('admin.upcoming_booking_report');
        }

        $upcoming_order_all    = Session::get('upcoming_order_all');
        $upcoming_order_id     = Session::get('upcoming_order_id');
        $upcoming_order_name   = Session::get('upcoming_order_name');
        $upcoming_order_email  = Session::get('upcoming_order_email');
        $upcoming_order_status = Session::get('upcoming_order_status');
        $upcoming_order_date   = Session::get('upcoming_order_date');

        $common['upcoming_order_all']     = $upcoming_order_all;
        $common['upcoming_order_id']      = $upcoming_order_id;
        $common['upcoming_order_name']    = $upcoming_order_name;
        $common['upcoming_order_email']   = $upcoming_order_email;
        $common['upcoming_order_status']  = $upcoming_order_status;
        $common['upcoming_order_date']    = $upcoming_order_date;

        $ProductCheckout = ProductCheckout::orderBy('id', 'desc');

        if ($upcoming_order_all) {
            $ProductCheckout = $ProductCheckout->where('order_id', 'LIKE', '%' . $upcoming_order_all . '%');
            $ProductCheckout = $ProductCheckout->orwhere('first_name', 'LIKE', '%' . $upcoming_order_all . '%');
            $ProductCheckout = $ProductCheckout->orwhere('last_name', 'LIKE', '%' . $upcoming_order_all . '%');
            $ProductCheckout = $ProductCheckout->orwhere('email', 'LIKE', '%' . $upcoming_order_all . '%');
            $ProductCheckout = $ProductCheckout->orwhere('phone_number', 'LIKE', '%' . $upcoming_order_all . '%');
        }

        if ($upcoming_order_id) {
            $ProductCheckout = $ProductCheckout->where('order_id', $upcoming_order_id);
        }

        if ($upcoming_order_name) {
            $ProductCheckout = $ProductCheckout->where('first_name', 'LIKE', '%' . $upcoming_order_name . '%');
            $ProductCheckout = $ProductCheckout->orwhere('last_name', 'LIKE', '%' . $upcoming_order_name . '%');
        }

        if ($upcoming_order_email) {
            $ProductCheckout = $ProductCheckout->where('email', 'LIKE', '%' . $upcoming_order_email . '%');
        }


        if ($upcoming_order_date) {
            $getordersDate = explode('to', $upcoming_order_date);
            $formdate = '';
            $todate = '';
             if (isset($getordersDate[0])) {
                $formdate = $getordersDate[0]." 00:00:00";
             }
             if (isset($getordersDate[1])) {
                $todate = $getordersDate[1]." 23:59:59";
             }
             if ($formdate!='' AND $todate!='') {
                 $ProductCheckout->whereDate('created_at', '>=',$formdate);
                 $ProductCheckout->whereDate('created_at', '<=',$todate);
             }
        }
        $ProductCheckout = $ProductCheckout->where('status', 'Success');
        $ProductCheckout = $ProductCheckout->get();


        $optionArr = [];
        $currentDate = Carbon::now()->timestamp;

        $nextDate = Carbon::now()->addDays(7)->timestamp;

        if (isset($request->date)) {
            if (!empty($request->date)) {
                $date_Arr = explode('-', $request->date);
                $common['startDate']  = trim($date_Arr[0]);
                $common['endDate']  = trim($date_Arr[1]);

                $startDate = $common['startDate'] . " 00:00:00";
                $endDate = $common['endDate'] . " 23:59:59";

                $currentDate = str_replace('/', '-', $startDate);
                $nextDate = str_replace('/', '-', $endDate);

                $currentDate = Carbon::parse($currentDate)->timestamp;
                $nextDate = Carbon::parse($nextDate)->timestamp;
            }
        }


        foreach ($ProductCheckout as $key => $value) {
            foreach (json_decode($value['extra']) as $ekey => $extra) {

                if ($extra->type == "excursion") {
                    if (isset($extra->option[0]->private_tour)) {
                        foreach ($extra->option[0]->private_tour as $ptkey => $PT) {
                            $date = Carbon::parse($PT->date)->timestamp;
                            if ($date > $currentDate && $date < $nextDate) {
                                $arr                 = [];
                                $arr['title']        = $PT->title;
                                $arr['date']         = $PT->date;
                                $arr['total_amount'] = $PT->total_amount;
                                $arr['type']         = $extra->type;
                                $arr['order_id']     = $value->order_id;
                                $arr['id']           = $value->id;
                                $optionArr[]         = $arr;
                            }
                        }
                    }
                    if (isset($extra->option[0]->tour_transfer)) {
                        foreach ($extra->option[0]->tour_transfer as $tkey => $TT) {
                            $date = Carbon::parse($TT->date)->timestamp;
                            if ($date > $currentDate && $date < $nextDate) {
                                $arr                 = [];
                                $arr['title']        = $TT->title;
                                $arr['date']         = $TT->date;
                                $arr['total_amount'] = $TT->total_amount;
                                $arr['type']         = $extra->type;
                                $arr['order_id']     = $value->order_id;
                                $arr['id']           = $value->id;
                                $optionArr[]         = $arr;
                            }
                        }
                    }
                    if (isset($extra->option[0]->group_percentage)) {
                        foreach ($extra->option[0]->group_percentage as $tkey => $GP) {
                            $date = Carbon::parse($GP->date)->timestamp;
                            if ($date > $currentDate && $date < $nextDate) {
                                $arr                 = [];
                                $arr['title']        = $GP->title;
                                $arr['date']         = $GP->date;
                                $arr['total_amount'] = $GP->amount;
                                $arr['type']         = $extra->type;
                                $arr['order_id']     = $value->order_id;
                                $arr['id']           = $value->id;
                                $optionArr[]         = $arr;
                            }
                        }
                    }
                }

                if ($extra->type == "Yatch") {
                    if (isset($extra->option[0])) {
                        $date = Carbon::parse($extra->option[0]->date)->timestamp;
                        if ($date > $currentDate && $date < $nextDate) {
                            $arr                 = [];
                            $arr['title']        = $extra->title;
                            $arr['date']         = $extra->option[0]->date;
                            $arr['total_amount'] = $extra->total;
                            $arr['type']         = $extra->type;
                            $arr['order_id']     = $value->order_id;
                            $arr['id']           = $value->id;
                            $optionArr[]         = $arr;
                        }
                    }
                }

                if ($extra->type == "Limousine") {
                    if (isset($extra->option[0])) {
                        $date = Carbon::parse($extra->option[0]->date)->timestamp;
                        if ($date > $currentDate && $date < $nextDate) {
                            $arr                 = [];
                            $arr['title']        = $extra->title;
                            $arr['date']         = $extra->option[0]->date;
                            $arr['total_amount'] = $extra->total;
                            $arr['type']         = $extra->type;
                            $arr['order_id']     = $value->order_id;
                            $arr['id']           = $value->id;
                            $optionArr[]         = $arr;
                        }
                    }
                }

                if ($extra->type == "lodge") {
                    if (isset($extra->option[0])) {
                        foreach ($extra->option as $key => $lodgeData) {

                            $date = Carbon::parse($lodgeData->lodge_arrival_date)->timestamp;
                            if ($date > $currentDate && $date < $nextDate) {
                                $arr                 = [];
                                $arr['title']        = $lodgeData->title;
                                $arr['date']         = $lodgeData->lodge_arrival_date;
                                $arr['total_amount'] = $lodgeData->option_total;
                                $arr['type']         = $extra->type;
                                $arr['order_id']     = $value->order_id;
                                $arr['id']           = $value->id;
                                $optionArr[]         = $arr;
                            }
                        }
                    }
                }
            }
        }
        usort($optionArr, function ($a, $b) {

            return strtotime($a['date']) - strtotime($b['date']);
        });



        $optionArr = $this->paginate($optionArr);



        return view('admin.report.upcoming_booking', compact('common', 'optionArr'));
    }

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page,  ['path' => request()->url(), 'query' => request()->query()]);
    }

    public function sales_report_export(Request $request)
    {
        $common['startDate']             = '';
        $common['endDate']             = '';

        $ProductCheckout = ProductCheckout::orderBy('id', 'desc');
        if (isset($request->date)) {
            if (!empty($request->date)) {
                $date_Arr = explode('-', $request->date);
                $common['startDate']  = trim($date_Arr[0]);
                $common['endDate']  = trim($date_Arr[1]);

                $startDate = $common['startDate'] . " 00:00:00";
                $endDate = $common['endDate'] . " 23:59:59";

                $startDate = str_replace('/', '-', $startDate);
                $endDate = str_replace('/', '-', $endDate);

                $ProductCheckout->whereDate('created_at', '>=', $startDate);
                $ProductCheckout->whereDate('created_at', '<=', $endDate);
            }
        }
        $ProductCheckout = $ProductCheckout->where('status', 'Success')->get();
        $fileName = 'Sales-Report-' . time() . '.csv';
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        );

        $columns = array(translate('S No.'), translate('Order ID'), translate('Email'), translate('Date'), translate('Shipping Address'), translate('Amount'));

        $callback = function () use ($columns, $ProductCheckout) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($ProductCheckout as $key => $value) {

                $row[translate('S No.')]            = $key + 1;
                $row[translate('Order ID')]         = $value['order_id'];
                $row[translate('Email')]            = $value['email'];
                $row[translate('Date')]             = date('Y-m-d', strtotime($value['created_at']));
                $row[translate('Shipping Address')] = $value['address'];
                $row[translate('Amount')]           = "AED " . $value['total'];

                fputcsv($file, array(
                    $row[translate('S No.')],
                    $row[translate('Order ID')],
                    $row[translate('Email')],
                    $row[translate('Date')],
                    $row[translate('Shipping Address')],
                    $row[translate('Amount')]
                ));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }


    public function best_seller_report_export(Request $request)
    {


        $get_products = Product::select('products.*', 'product_language.description as title')
            ->where('products.is_delete', 0)
            ->leftjoin('product_language', 'products.id', '=', 'product_language.product_id')
            ->groupBy('products.id')
            ->where('products.sales_count', '!=', 0)
            ->orderBy('products.sales_count', 'desc')->get();

        $fileName = 'Best-Seller-Report-' . time() . '.csv';
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        );

        $columns = array(translate('S No.'), translate('Product Name'), translate('Date'), translate('Product Type'), translate('Sales Count'));

        $callback = function () use ($columns, $get_products) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($get_products as $key => $value) {

                $row[translate('S No.')]        = $key + 1;
                $row[translate('Product Name')] = $value['title'];
                $row[translate('Date')]         = date('Y-m-d', strtotime($value['created_at']));
                $row[translate('Product Type')] = $value['product_type'];
                $row[translate('Sales Count')]  = $value['sales_count'];

                fputcsv($file, array(
                    $row[translate('S No.')],
                    $row[translate('Product Name')],
                    $row[translate('Date')],
                    $row[translate('Product Type')],
                    $row[translate('Sales Count')]
                ));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function upcoming_booking_report_export(Request $request)
    {
        $common['startDate']             = '';
        $common['endDate']             = '';

        $ProductCheckout = ProductCheckout::where('status', 'Success')->orderBy('id', "desc")->get();

        $optionArr = [];
        $currentDate = Carbon::now()->timestamp;

        $nextDate = Carbon::now()->addDays(7)->timestamp;

        if (isset($request->date)) {
            if (!empty($request->date)) {
                $date_Arr = explode('-', $request->date);
                $common['startDate']  = trim($date_Arr[0]);
                $common['endDate']  = trim($date_Arr[1]);

                $startDate = $common['startDate'] . " 00:00:00";
                $endDate = $common['endDate'] . " 23:59:59";

                $currentDate = str_replace('/', '-', $startDate);
                $nextDate = str_replace('/', '-', $endDate);

                $currentDate = Carbon::parse($currentDate)->timestamp;
                $nextDate = Carbon::parse($nextDate)->timestamp;
            }
        }


        foreach ($ProductCheckout as $key => $value) {
            foreach (json_decode($value['extra']) as $ekey => $extra) {

                if ($extra->type == "excursion") {
                    if (isset($extra->option[0]->private_tour)) {
                        foreach ($extra->option[0]->private_tour as $ptkey => $PT) {
                            $date = Carbon::parse($PT->date)->timestamp;
                            if ($date > $currentDate && $date < $nextDate) {
                                $arr                 = [];
                                $arr['title']        = $PT->title;
                                $arr['date']         = $PT->date;
                                $arr['total_amount'] = $PT->total_amount;
                                $arr['type']         = $extra->type;
                                $arr['order_id']     = $value->order_id;
                                $arr['id']           = $value->id;
                                $optionArr[]         = $arr;
                            }
                        }
                    }
                    if (isset($extra->option[0]->tour_transfer)) {
                        foreach ($extra->option[0]->tour_transfer as $tkey => $TT) {
                            $date = Carbon::parse($TT->date)->timestamp;
                            if ($date > $currentDate && $date < $nextDate) {
                                $arr                 = [];
                                $arr['title']        = $TT->title;
                                $arr['date']         = $TT->date;
                                $arr['total_amount'] = $TT->total_amount;
                                $arr['type']         = $extra->type;
                                $arr['order_id']     = $value->order_id;
                                $arr['id']           = $value->id;
                                $optionArr[]         = $arr;
                            }
                        }
                    }
                    if (isset($extra->option[0]->group_percentage)) {
                        foreach ($extra->option[0]->group_percentage as $tkey => $GP) {
                            $date = Carbon::parse($GP->date)->timestamp;
                            if ($date > $currentDate && $date < $nextDate) {
                                $arr                 = [];
                                $arr['title']        = $GP->title;
                                $arr['date']         = $GP->date;
                                $arr['total_amount'] = $GP->amount;
                                $arr['type']         = $extra->type;
                                $arr['order_id']     = $value->order_id;
                                $arr['id']           = $value->id;
                                $optionArr[]         = $arr;
                            }
                        }
                    }
                }

                if ($extra->type == "Yatch") {
                    if (isset($extra->option[0])) {
                        $date = Carbon::parse($extra->option[0]->date)->timestamp;
                        if ($date > $currentDate && $date < $nextDate) {
                            $arr                 = [];
                            $arr['title']        = $extra->title;
                            $arr['date']         = $extra->option[0]->date;
                            $arr['total_amount'] = $extra->total;
                            $arr['type']         = $extra->type;
                            $arr['order_id']     = $value->order_id;
                            $arr['id']           = $value->id;
                            $optionArr[]         = $arr;
                        }
                    }
                }

                if ($extra->type == "Limousine") {
                    if (isset($extra->option[0])) {
                        $date = Carbon::parse($extra->option[0]->date)->timestamp;
                        if ($date > $currentDate && $date < $nextDate) {
                            $arr                 = [];
                            $arr['title']        = $extra->title;
                            $arr['date']         = $extra->option[0]->date;
                            $arr['total_amount'] = $extra->total;
                            $arr['type']         = $extra->type;
                            $arr['order_id']     = $value->order_id;
                            $arr['id']           = $value->id;
                            $optionArr[]         = $arr;
                        }
                    }
                }

                if ($extra->type == "lodge") {
                    if (isset($extra->option[0])) {
                        foreach ($extra->option as $key => $lodgeData) {

                            $date = Carbon::parse($lodgeData->lodge_arrival_date)->timestamp;
                            if ($date > $currentDate && $date < $nextDate) {
                                $arr                 = [];
                                $arr['title']        = $lodgeData->title;
                                $arr['date']         = $lodgeData->lodge_arrival_date;
                                $arr['total_amount'] = $lodgeData->option_total;
                                $arr['type']         = $extra->type;
                                $arr['order_id']     = $value->order_id;
                                $arr['id']           = $value->id;
                                $optionArr[]         = $arr;
                            }
                        }
                    }
                }
            }
        }
        usort($optionArr, function ($a, $b) {

            return strtotime($a['date']) - strtotime($b['date']);
        });



        $fileName = 'Upcoming-Booking-Report-' . time() . '.csv';
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        );

        $columns = array(translate('S No.'), translate('Order ID'), translate('Product Name'), translate('Date'), translate('Product Type'), translate('Amount'));

        $callback = function () use ($columns, $optionArr) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($optionArr as $key => $value) {

                $row[translate('S No.')]        = $key + 1;
                $row[translate('Order ID')]     = $value['order_id'];
                $row[translate('Product Name')] = $value['title'];
                $row[translate('Date')]         = date('Y-m-d', strtotime($value['date']));
                $row[translate('Product Type')] = $value['type'];
                $row[translate('Amount')]       = "AED " . $value['total_amount'];

                fputcsv($file, array(
                    $row[translate('S No.')],
                    $row[translate('Order ID')],
                    $row[translate('Product Name')],
                    $row[translate('Date')],
                    $row[translate('Product Type')],
                    $row[translate('Amount')]
                ));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
