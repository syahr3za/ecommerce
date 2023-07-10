<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('list', 'confirmed_list', 'packed_list', 'sent_list', 'accepted_list', 'finished_list');
        $this->middleware('auth:api')->only('destroy', 'store', 'update', 'changeStatus', 'confirmed', 'new', 'packed', 'sent', 'accepted', 'finished');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('member')->get();

        return response()->json([
            'data' => $orders
        ]);
    }

    public function list()
    {
        return view('order.index');
    }

    public function confirmed_list()
    {
        return view('order.confirmed');
    }

    public function packed_list()
    {
        return view('order.packed');
    }

    public function sent_list()
    {
        return view('order.sent');
    }

    public function accepted_list()
    {
        return view('order.accepted');
    }

    public function finished_list()
    {
        return view('order.finished');
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
            'member_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input = $request->all();
        $order = Order::create($input);

        for ($i = 0; $i < count($input['product_id']); $i++) {
            OrderDetail::create([
                'order_id' => $order('id'),
                'product_id' => $input('product_id'),
                'qty' => $input('qty'),
                'size' => $input('size'),
                'color' => $input('color'),
                'total' => $input('total'),
            ]);
        }

        return response()->json([
            'data' => $order
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return response()->json([
            'data' => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'member_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input = $request->all();
        $order->update($input);

        OrderDetail::where('order_id', $order['id'])->delete();

        for ($i = 0; $i < count($input['product_id']); $i++) {
            OrderDetail::create([
                'order_id' => $order('id'),
                'product_id' => $input('product_id'),
                'qty' => $input('qty'),
                'size' => $input('size'),
                'color' => $input('color'),
                'total' => $input('total'),
            ]);
        }

        return response()->json([
            'message' => 'Updated resource',
            'data' => $order
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json([
            'message' => 'Successfully'
        ]);
    }

    public function confirmed()
    {
        $orders = Order::with('member')->where('status', 'confirmed')->get();

        return response()->json([
            'data' => $orders
        ]);
    }

    public function new()
    {
        $orders = Order::with('member')->where('status', 'new')->get();

        return response()->json([
            'data' => $orders
        ]);
    }

    public function packed()
    {
        $orders = Order::with('member')->where('status', 'packed')->get();

        return response()->json([
            'data' => $orders
        ]);
    }

    public function sent()
    {
        $orders = Order::with('member')->where('status', 'sent')->get();

        return response()->json([
            'data' => $orders
        ]);
    }

    public function accepted()
    {
        $orders = Order::with('member')->where('status', 'accepted')->get();

        return response()->json([
            'data' => $orders
        ]);
    }

    public function finished()
    {
        $orders = Order::with('member')->where('status', 'finished')->get();

        return response()->json([
            'data' => $orders
        ]);
    }

    public function changeStatus(Request $request, Order $order)
    {
        $order->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'success',
            'data' => $order
        ]);
    }
}
