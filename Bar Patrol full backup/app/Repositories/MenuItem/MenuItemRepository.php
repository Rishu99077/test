<?php

namespace App\Repositories\MenuItem;

use App\Repositories\MenuItem\MenuItemInterface;
use App\Models\MenuItemOptionalAddons;
use Illuminate\Support\Facades\DB;
use App\Models\MenuItem;
use Auth;

class MenuItemRepository implements MenuItemInterface
{
    private $menuItem;

    public function __construct(MenuItem $menuItem)
    {
        $this->menuItem = $menuItem;
    }

    /*
    * Function to store new category
    */
    public function store($request)
    {
        return MenuItem::create($request);
    }

    /*
    * Function to remove category
    */
    public function remove($id)
    {
        return $this->menuItem::destroy($id);
    }

    /*
    * Function to change category status
    */
    public function changeStatus($id, $status)
    {
        return $this->menuItem::where('id', $id)->update(['status' => $status]);
    }

    /*
    * Function to update category
    */
    public function update($request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data["image"] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/ItemImages');
            $image->move($destinationPath, $img);
        }

        if ($request->filled('addons')) {
            MenuItemOptionalAddons::where('menu_item_id', $request->id)->delete();
            foreach ($request->addons as $val) {
                $option["menu_item_id"] = $request->id;
                $option["optional_addon_id"] = $val;
                MenuItemOptionalAddons::create($option);
            }
        }

        $item = MenuItem::findOrFail($request->id);
        $data["name"] = ucfirst(strtolower($request->name));
        $data["pickup_price"] = $request->pickup_price;
        $data["ndelivery_priceame"] = $request->delivery_price;
        $data["description"] = $request->description;
        $data["item_code"] = $request->item_code;
        $data["vat"] = $request->vat;
        $data["discount"] = $request->discount;
        $data["pickup_default_preparation_time"] = '00:00:00';
        $data["delivery_default_preparation_time"] = $request->delivery_default_preparation_time;
        $data["category_id"] = $request->category_id;
        return $item->update($data);
    }
}
