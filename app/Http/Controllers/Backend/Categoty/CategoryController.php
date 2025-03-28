<?php

namespace App\Http\Controllers\Backend\Categoty;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**CATEGORY INDEX */
    public function categoryIndex()
    {
        $sub_categories = Category::select('id', 'category_name')
            ->whereNotNull('category_name') // Ensures category_name is not null
            ->where('category_name', '!=', '') // Ensures it's not an empty string
            ->get();

        return view('backend.categorys.category', compact('sub_categories'));
    }


    /** STORE CATEGORY */
    public function categoryStore(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name',
        ]);

        // Create a new category
        $category = new Category();
        $category->category_name = $request->category_name;
        $category->save();

        // Return JSON response for AJAX OR Redirect for normal form submission
        if ($request->ajax()) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Category inserted successfully!'
                ]
            );
        }

        // return back()->with('success', 'Category inserted successfully!');
    }

    /**SUB CATEGORY  STORE*/
    public function subCategoryStore(Request $request)
    {
        $request->validate([
            'foreign_id' => 'required',
            'sub_category' => 'required|unique:categories,sub_category_name'
        ]);


        $sub_category = new Category();
        $sub_category->foreign_id = $request->foreign_id;
        $sub_category->sub_category_name = $request->sub_category;
        $sub_category->save();

        if ($request->ajax()) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'sub Category inserted successfully!'
                ]
            );
        }
    }


    /**ALL CATEGORIES */
    public function allCategories(Request $request)
    {
        if ($request->ajax()) {
            $allCategories = Category::with('subcategories')->whereNull('foreign_id');

            return DataTables::of($allCategories)
                ->addColumn('subcategories', function ($category) {
                    if ($category->subcategories->isEmpty()) {
                        return '<span class="badge bg-secondary">No Subcategories</span>';
                    }

                    return $category->subcategories->map(function ($sub) {
                        return '<span class="badge bg-info">' . $sub->sub_category_name . '</span>';
                    })->implode(' ');
                })
                ->addColumn('created_at', function ($category) {
                    return $category->created_at->format('d M Y, h:i A');
                })
                ->addColumn('action', function ($category) {
                    return '
                        <a href="'. route('category.category.edit', $category->id).'" class="btn btn-sm btn-primary edit-category">Edit</a>
                        <button class="btn btn-sm btn-danger delete-category" data-id="' . $category->id . '">Delete</button>
                    ';
                })
                ->rawColumns(['subcategories', 'action'])
                ->make(true);
        }

        return view('backend.categorys.allCategories');
    }


    /**DELETE CATEGORY */
    public function deleteCategory($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return response()->json(['success' => 'Category deleted successfully!']);
        } else {
            return response()->json(['error' => 'Category not found!'], 404);
        }
    }


    public function editCategory($id){
    return $id;
    } 


}
