<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsLatterSubscribe;
use App\Models\Language;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    public function index(){
        $common          = array();
        $common['title'] = "Subscribers list";
        Session::put("TopMenu", "Subscribers list");
        Session::put("SubMenu", "Subscribers list");

        $get_newsletter = NewsLatterSubscribe::orderBy('id','desc')->paginate(config('adminconfig.records_per_page'));
            
        return view('admin.subscribers.index', compact('common', 'get_newsletter'));
    }

}