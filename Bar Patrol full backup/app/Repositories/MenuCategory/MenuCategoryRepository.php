<?php

namespace App\Repositories\MenuCategory;

use App\Repositories\MenuCategory\MenuCategoryInterface;
use App\Models\MenuCategory;
use App\Models\MenuCategoryOptionalAddons;
use Auth;

class MenuCategoryRepository implements MenuCategoryInterface
{
    private $menuCategory;

    public function __construct(MenuCategory $menuCategory)
    {
        $this->menuCategory = $menuCategory;
    }

    /*
    * Function to store new category
    */
    public function store($request)
    {
        return $this->menuCategory::create($request);
        return true;
    }

    /*
    * Function to remove category
    */
    public function remove($id)
    {
        return $this->menuCategory::destroy($id);
    }

    /*
    * Function to change category status
    */
    public function changeStatus($id, $status)
    {
        return $this->menuCategory::where('id', $id)->update(['status' => $status]);
    }

    /*
    * Function to update category
    */
    public function update($request)
    {
        $img = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $img = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/category');
            $image->move($destinationPath, $img);
            $data["image"] = $img;
        }
        MenuCategoryOptionalAddons::where('menu_category_id', $request -> id)->delete();
        if ($request->filled('addons')) {
            foreach ($request->addons as $val) {
                $option["menu_category_id"] = $request -> id;
                $option["optional_addon_id"] = $val;
                MenuCategoryOptionalAddons::create($option);
            }
        }
        $data["category_name"] = $request->category_name;
        return $this->menuCategory::where('id', $request -> id)->update($data);
    }

    public function updateData($id,$request)
    {   
        return $this->menuCategory::where('id', $id)->update($request);
    }

    /*
    * Function to delete category image
    */

    public function deleteImage($id, $field)
    {
        return $this->menuCategory::where('id', $id)->update([$field => '']);
    }

    /*
    * Function to get addons through category id
    */
    public function getAddons($category_id)
    {

        return $this->menuCategory::where('id', $category_id)->get();
    }
}
