<?php

namespace App\Http\Controllers\Backend\Categoty;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**CATEGORY INDEX */
    public function categoryIndex()
    {
        return view('backend.categorys.category');
    }


    /**STORE CAREGORY */
    public function categoryStore(Request $request)
    {
        $category =  new Category();
        $category->category_name = $request->category_name;
        $category->save();
        return back();
    }
}
