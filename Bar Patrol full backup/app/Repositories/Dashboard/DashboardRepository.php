<?php

namespace App\Repositories\Dashboard;

use App\Repositories\Dashboard\DashboardInterface;
use App\Models\Dashboard;
use Auth;

class DashboardRepository implements DashboardInterface
{
    private $dashboard;

    public function __construct(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    /*
    * Function to update optional addon
    */
    public function update($request)
    {
        $logo = '';
        if ($request->hasFile('logo')) {
            $img = $request->file('logo');
            $logo = time().'.'.$img->getClientOriginalExtension();
            $destinationPath = public_path('/dashboard/logo');
            $img->move($destinationPath, $logo);
            $data["logo"] = $logo;
        }

        $bg_image = '';
        if ($request->hasFile('background_image')) {
            $image = $request->file('background_image');
            $bg_image = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/dashboard/background_image');
            $image->move($destinationPath, $bg_image);
            $data["background_image"] = $bg_image;
        }
        $addon = Dashboard::findOrFail($request->id);
        $data["name"] = $request->name;
        $data["address"] = $request->address;
        $data["description"] = $request->description;
        $data["city_id"] = $request->city_id;


        $data["state_id"] = $request->state_id;
        $data["zipcode"] = $request->zipcode;
        if ($request->has('phone_no')) {
            $data["phone_no"] = $request->phone_no;
        }
        $data["opening_time"] = date('H:i:s', strtotime($request->opening_time));
        $data["closing_time"] = date('H:i:s', strtotime($request->closing_time));
        return $addon->update($data);
    }

    /*
    * Function to store dashboard branch
    */
    public function store($request)
    {
        $data["branch_type"] = "main";
        $data["admin_id"] = $request->id;
        $data["name"] = $request->name;
        $data["address"] = $request->address;
        $data["state_id"] = $request->state_id;
        $data["city_id"] = $request->city_id;
        $data["zipcode"] = $request->zipcode;
        if ($request->has('phone_no')) {
            $data["phone_no"] = $request->phone_no;
        }
        return Dashboard::create($data);
    }

    /*
    * Function to store dashboard branch
    */
    public function storeBranch($request)
    {
        $request["admin_id"] = $request["id"];
        $request["branch_type"] = 'sub-branch';
        $request["opening_time"] = date('H:i:s', strtotime($request["opening_time"]));
        $request["closing_time"] = date('H:i:s', strtotime($request["closing_time"]));
        return Dashboard::create($request);
    }



    /*
    * Function to remove branch
    */
    public function remove($id)
    {
        return $this->dashboard::destroy($id);
    }

    /*
    * Function to change branch status
    */
    public function changeStatus($id, $status)
    {
        return $this->dashboard::where('id', $id)->update(['status' => $status]);
    }

    /*
    * Function to make dashboard live
    */
    public function makeItLive($status)
    {
        return $this->dashboard::where('id', session('restaurant_id'))->update(['is_live' => $status]);
    }

    /*
    * Function to delet branch image
    */
    public function deleteImage($id, $field)
    {
        return $this->dashboard::where('id', $id)->update([$field => '']);
    }
}
