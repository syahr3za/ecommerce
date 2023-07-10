@extends('layout.home')

@section('title', 'Checkout')

@section('content')
<section class="section-wrap checkout pb-70">
    <div class="container relative">
        <div class="row">
            <div class="ecommerce col-xs-12">
                <h2>My Payments</h2>
                <table class="table table-ordered table-hover table-striped">
                    <thead>
                        <th>No</th>
                        <th>Date</th>
                        <th>Nominal Transfer</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        @foreach ($payments as $index => $payment)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$payment->created_at}}</td>
                            <td>Rp. {{number_format($payment->qty)}}</td>
                            <td>{{$payment->status}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- My orders -->
                <h2>My Orders</h2>
                <table class="table table-ordered table-hover table-striped">
                    <thead>
                        <th>No</th>
                        <th>Date</th>
                        <th>Grand Total</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        @foreach ($orders as $index => $order)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$order->created_at}}</td>
                            <td>Rp. {{number_format($order->grand_total)}}</td>
                            <td>{{$order->status}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection