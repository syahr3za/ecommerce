<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class SubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('list');
        $this->middleware('auth:api')->only('destroy', 'store', 'update');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sub_categories = SubCategory::with('category')->get();

        return response()->json([
            'success' => true,
            'data' => $sub_categories
        ]);
    }

    public function list()
    {
        $categories = Category::all();

        return view('subcategory.index', compact('categories'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'subcategory_name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input = $request->all();

        if ($request->has('image')) {
            $image = $request->file('image');
            $image_name = time() . rand(1, 9) . '.' . $image->getClientOriginalExtension();
            $image->move('uploads', $image_name);
            $input['image'] = $image_name;
        }

        $subcategory = SubCategory::create($input);

        return response()->json([
            'success' => true,
            'data' => $subcategory
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        return response()->json([
            'success' => true,
            'data' => $subCategory
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'subcategory_name' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input = $request->all();

        if ($request->has('image')) {
            File::delete('uploads/' . $subCategory->image);
            $image = $request->file('image');
            $image_name = time() . rand(1, 9) . '.' . $image->getClientOriginalExtension();
            $image->move('uploads', $image_name);
            $input['image'] = $image_name;
        } else {
            unset($input['image']);
        }

        $subCategory->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Updated resource',
            'data' => $subCategory
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subCategory)
    {
        File::delete('uploads/' . $subCategory->image);
        $subCategory->delete();

        return response()->json([
            'success' => true,
            'message' => 'Successfully'
        ]);
    }
}
