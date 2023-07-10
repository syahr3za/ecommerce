<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
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
        $sliders = Slider::all();

        return response()->json([
            'success' => true,
            'data' => $sliders
        ]);
    }

    public function list()
    {
        $sliders = Slider::all();
        return view('slider.index', compact('sliders'));
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
            'slider_name' => 'required',
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

        $slider = Slider::create($input);

        return response()->json([
            'success' => true,
            'data' => $slider
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        return response()->json([
            'success' => true,
            'data' => $slider
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $validator = Validator::make($request->all(), [
            'slider_name' => 'required',
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
            File::delete('uploads/' . $slider->image);
            $image = $request->file('image');
            $image_name = time() . rand(1, 9) . '.' . $image->getClientOriginalExtension();
            $image->move('uploads', $image_name);
            $input['image'] = $image_name;
        } else {
            unset($input['image']);
        }

        $slider->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Updated resource',
            'data' => $slider
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        File::delete('uploads/' . $slider->image);
        $slider->delete();

        return response()->json([
            'success' => true,
            'message' => 'Successfully'
        ]);
    }
}
