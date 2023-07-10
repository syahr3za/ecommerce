@extends('layout.home')

@section('title', 'Cart')

@section('content')
<section class="section-wrap shopping-cart">
    <div class="container relative">
        <form class="form-cart">
            <input type="hidden" name="member_id" value="{{Auth::guard('webmember')->user()->id}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-wrap mb-30">
                        <table class="shop_table cart table">
                            <thead>
                                <tr>
                                    <th class="product-name" colspan="2">Product</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-subtotal" colspan="2">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $cart)
                                <input type="hidden" name="product_id[]" value="{{$cart->product->id}}">
                                <input type="hidden" name="qty[]" value="{{$cart->qty}}">
                                <input type="hidden" name="size[]" value="{{$cart->size}}">
                                <input type="hidden" name="color[]" value="{{$cart->color}}">
                                <input type="hidden" name="total[]" value="{{$cart->total}}">
                                <tr class="cart_item">
                                    <td class="product-thumbnail">
                                        <a href="#">
                                            <img src="/uploads/{{$cart->product->image}}" alt="">
                                        </a>
                                    </td>
                                    <td class="product-name">
                                        <a href="#">{{$cart->product->product_name}}</a>
                                        <ul>
                                            <li>Size: {{$cart->size}}</li>
                                            <li>Color: {{$cart->color}}</li>
                                        </ul>
                                    </td>
                                    <td class="product-price">
                                        <span class="amount">{{ "Rp. " . number_format($cart->product->price)}}</span>
                                    </td>
                                    <td class="product-quantity">
                                        <span class="amount">{{ $cart->qty }}</span>
                                    </td>
                                    <td class="product-subtotal">
                                        <span class="amount">{{ "Rp. " . number_format($cart->total)}}</span>
                                    </td>
                                    <td class="product-remove">
                                        <a href="/delete_from_cart/{{$cart->id}}" class="remove" title="Remove this item">
                                            <i class="ui-close"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row mb-50">
                        <div class="col-md-5 col-sm-12">
                        </div>
                        <div class="col-md-7">
                            <div class="actions">
                                <div class="wc-proceed-to-checkout">
                                    <a href="#" class="btn btn-lg btn-dark checkout"><span>proceed to checkout</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 shipping-calculator-form">
                    <h2 class="heading relative uppercase bottom-line full-grey mb-30">Calculate Shipping</h2>
                    <p class="form-row form-row-wide">
                        <select name="province" id="province" class="country_to_state province" rel="calc_shipping_state">
                            <option value="">Select province</option>
                            @foreach ($province->rajaongkir->results as $province)
                            <option value="{{$province->province_id}}">{{$province->province}}</option>
                            @endforeach
                        </select>
                    </p>

                    <p class="form-row form-row-wide">
                        <select name="city" id="city" class="country_to_state city" rel="calc_shipping_state"></select>
                    </p>

                    <div class="row row-10">
                        <div class="col-sm-12">
                            <p class="form-row form-row-wide">
                                <input type="text" class="input-text weight" placeholder="weight" name="weight" id="weight">
                            </p>
                        </div>
                    </div>

                    <p>
                        <a href="#" name="calc_shipping" class="btn btn-lg btn-stroke mt-10 mb-mdm-40 update-total" style="padding: 20px 40px">Update Totals</a>
                    </p>
                </div>

                <div class="col-md-6">
                    <div class="cart_totals">
                        <h2 class="heading relative bottom-line full-grey uppercase mb-30">Cart Totals</h2>
                        <table class="table shop_table">
                            <tbody>
                                <tr class="cart-subtotal">
                                    <th>Cart Subtotal</th>
                                    <td>
                                        <span class="amount cart-total">{{$cart_total}}</span>
                                    </td>
                                </tr>
                                <tr class="shipping">
                                    <th>Shipping</th>
                                    <td>
                                        <span class="shipping-cost">0</span>
                                    </td>
                                </tr>
                                <tr class="order-total">
                                    <th>Order Total</th>
                                    <td>
                                        <input type="hidden" name="grand_total" class="grand_total">
                                        <strong><span class="amount grand-total">0</span></strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('js')
<script>
    // get province
    $(function() {
        $('.province').change(function() {
            $.ajax({
                url: '/get_city/' + $(this).val(),
                success: function(data) {
                    data = JSON.parse(data)
                    option = ""
                    data.rajaongkir.results.map((city) => {
                        option += `<option value=${city.city_id}>${city.city_name}</option>`
                    })
                    $('.city').html(option)
                }
            });
        });
        // update total with city
        $('.update-total').click(function(e) {
            e.preventDefault()
            $.ajax({
                url: '/get_shipping/' + $('.city').val() + '/' + $('.weight').val(),
                success: function(data) {
                    data = JSON.parse(data)
                    grandtotal = parseInt(data.rajaongkir.results[0].costs[0].cost[0].value) + parseInt($('.cart-total').text())
                    $('.shipping-cost').text(data.rajaongkir.results[0].costs[0].cost[0].value)
                    $('.grand-total').text(grandtotal)
                    $('.grand_total').val(grandtotal)
                }
            });
        });
        // to payment
        $('.checkout').click(function(e) {
            e.preventDefault()
            $.ajax({
                url: '/checkout_orders',
                method: 'POST',
                data: $('.form-cart').serialize(),
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}",
                },
                success: function() {
                    location.href = '/checkout'
                }
            })
        })
    });
</script>
@endpush