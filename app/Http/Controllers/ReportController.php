<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('index');
        $this->middleware('auth:api')->only('get_reports');
    }

    public function get_reports(Request $request)
    {
        $report = DB::table('order_details')
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->select(DB::raw('COUNT(*) AS purchased_amount, product_name, price, SUM(qty) AS total_qty, SUM(total) AS income'))
            ->whereRaw("date(order_details.created_at) >= '$request->from'")
            ->whereRaw("date(order_details.created_at) <= '$request->until'")
            ->groupBy('product_id', 'product_name', 'price')
            ->get();

        return response()->json([
            'data' => $report
        ]);
    }
    public function index()
    {
        return view('report.index');
    }
}
