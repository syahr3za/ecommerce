<?php

namespace App\Http\Controllers;

use App\Models\Testimony;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class TestimonyController extends Controller
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
        $testimonies = Testimony::all();

        return response()->json([
            'success' => true,
            'data' => $testimonies
        ]);
    }

    public function list()
    {
        return view('testimony.index');
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
            'testimony_name' => 'required',
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

        $testimony = Testimony::create($input);

        return response()->json([
            'success' => true,
            'data' => $testimony
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimony $testimony)
    {
        return response()->json([
            'success' => true,
            'data' => $testimony
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimony $testimony)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimony $testimony)
    {
        $validator = Validator::make($request->all(), [
            'testimony_name' => 'required',
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
            File::delete('uploads/' . $testimony->image);
            $image = $request->file('image');
            $image_name = time() . rand(1, 9) . '.' . $image->getClientOriginalExtension();
            $image->move('uploads', $image_name);
            $input['image'] = $image_name;
        } else {
            unset($input['image']);
        }

        $testimony->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Updated resource',
            'data' => $testimony
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimony $testimony)
    {
        File::delete('uploads/' . $testimony->image);
        $testimony->delete();

        return response()->json([
            'success' => true,
            'message' => 'Successfully'
        ]);
    }
}
