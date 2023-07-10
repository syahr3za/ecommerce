<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Testimony;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        $categories = Category::all();
        $testimonies = Testimony::all();
        $products = Product::skip(0)->take(8)->get();

        return view('home.index', compact('sliders', 'categories', 'testimonies', 'products'));
    }

    public function products($subcategory_id)
    {
        $products = Product::where('subcategory_id', $subcategory_id)->get();

        return view('home.products', compact('products'));
    }

    public function add_to_cart(Request $request)
    {
        $input = $request->all();
        Cart::create($input);
    }

    public function delete_from_cart(Cart $cart)
    {
        $cart->delete();
        return redirect('/cart');
    }

    public function product($product_id)
    {
        $product = Product::find($product_id);
        $latest_products = Product::orderByDesc('created_at')->offset(0)->limit(10)->get();
        return view('home.product', compact('product', 'latest_products'));
    }

    public function cart()
    {
        if (!Auth::guard('webmember')->user()) {
            return redirect('/login_member');
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 550ca10b74c58e1d23f8d2047fed36a4"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }

        $province = json_decode($response);

        $carts = Cart::where('member_id', Auth::guard('webmember')->user()->id)->where('is_checkout', 0)->get();
        $cart_total = Cart::where('member_id', Auth::guard('webmember')->user()->id)->where('is_checkout', 0)->sum('total');

        return view('home.cart', compact('carts', 'province', 'cart_total'));
    }

    public function get_city($id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=" . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 550ca10b74c58e1d23f8d2047fed36a4"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    public function get_shipping($destination, $weight)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=254&destination=" . $destination . "&weight=" . $weight . "&courier=jne",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 550ca10b74c58e1d23f8d2047fed36a4"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    public function checkout_orders(Request $request)
    {
        $id = DB::table('orders')->insertGetId([
            'member_id' => $request->member_id,
            'invoice' => date('ymds'),
            'grand_total' => $request->grand_total,
            'status' => 'New',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        for ($i = 0; $i < count($request->product_id); $i++) {
            DB::table('order_details')->insert([
                'order_id' => $id,
                'product_id' => $request->product_id[$i],
                'qty' => $request->qty[$i],
                'size' => $request->size[$i],
                'color' => $request->color[$i],
                'total' => $request->total[$i],
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        Cart::where('member_id', Auth::guard('webmember')->user()->id)->update([
            'is_checkout' => 1
        ]);
    }

    public function checkout()
    {
        $about = About::first();
        $orders = Order::where('member_id', Auth::guard('webmember')->user()->id)->first();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 550ca10b74c58e1d23f8d2047fed36a4"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }

        $province = json_decode($response);

        return view('home.checkout', compact('about', 'orders', 'province'));
    }

    public function payments(Request $request)
    {
        Payment::create([
            'order_id' => $request->order_id,
            'member_id' => Auth::guard('webmember')->user()->id,
            'qty' => $request->qty,
            'province' => $request->province,
            'district' => $request->district,
            'subdistrict' => "",
            'detail_address' => $request->detail_address,
            'status' => 'AWAIT',
            'account_number' => $request->account_number,
            'payer_name' => $request->payer_name,
        ]);

        return redirect('/orders');
    }

    public function orders()
    {
        $orders = Order::where('member_id', Auth::guard('webmember')->user()->id)->get();
        $payments = Payment::where('member_id', Auth::guard('webmember')->user()->id)->get();
        return view('home.orders', compact('orders', 'payments'));
    }

    public function about()
    {
        $about = About::first();
        $testimonies = Testimony::all();

        return view('home.about', compact('about', 'testimonies'));
    }

    public function contact()
    {
        $about = About::first();

        return view('home.contact', compact('about'));
    }
}
