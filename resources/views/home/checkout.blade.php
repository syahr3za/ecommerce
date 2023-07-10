@extends('layout.home')

@section('title', 'Checkout')

@section('content')
<!-- Billing address -->
<section class="section-wrap checkout pb-70">
    <div class="container relative">
        <div class="row">
            <div class="ecommerce col-xs-12">
                <form name="checkout" class="checkout ecommerce-checkout row" method="POST" action="/payments">
                    @csrf
                    <input type="hidden" name="order_id" value="{{$orders->id}}">
                    <div class="col-md-8" id="customer_details">
                        <div>
                            <h2 class="heading uppercase bottom-line full-grey mb-30">billing address</h2>
                            <p class="form-row form-row-first validate-required ecommerce-invalid ecommerce-invalid-required-field" id="billing_first_name_field">
                                <label for="billing_first_name">Province
                                    <abbr class="required" title="required">*</abbr>
                                </label>
                                <select name="province" id="province" class="country_to_state province" rel="calc_shipping_state">
                                    <option value="">Select province</option>
                                    @foreach ($province->rajaongkir->results as $province)
                                    <option value="{{$province->province_id}}">{{$province->province}}</option>
                                    @endforeach
                                </select>
                            </p>
                            <p class="form-row form-row-first validate-required ecommerce-invalid ecommerce-invalid-required-field" id="billing_first_name_field">
                                <label for="billing_first_name">City
                                    <abbr class="required" title="required">*</abbr>
                                </label>
                                <select name="district" id="city" class="country_to_state city" rel="calc_shipping_state">
                                </select>
                            </p>
                            <p class="form-row form-row-first validate-required ecommerce-invalid ecommerce-invalid-required-field" id="billing_first_name_field">
                                <label for="billing_first_name">Address Detail
                                    <abbr class="required" title="required">*</abbr>
                                </label>
                                <input type="text" class="input-text" placeholder="Enter your address" name="detail_address" id="billing_first_name">
                            </p>
                            <p class="form-row form-row-first validate-required ecommerce-invalid ecommerce-invalid-required-field" id="billing_first_name_field">
                                <label for="billing_first_name">On behalf of
                                    <abbr class="required" title="required">*</abbr>
                                </label>
                                <input type="text" class="input-text" placeholder="Enter your name" name="payer_name" id="billing_first_name">
                            </p>
                            <p class="form-row form-row-first validate-required ecommerce-invalid ecommerce-invalid-required-field" id="billing_first_name_field">
                                <label for="billing_first_name">Account Number
                                    <abbr class="required" title="required">*</abbr>
                                </label>
                                <input type="text" class="input-text" placeholder="Enter your account number" name="account_number" id="billing_first_name">
                            </p>
                            <p class="form-row form-row-first validate-required ecommerce-invalid ecommerce-invalid-required-field" id="billing_first_name_field">
                                <label for="billing_first_name">Nominal Transfer
                                    <abbr class="required" title="required">*</abbr>
                                </label>
                                <input type="text" class="input-text" placeholder value name="qty" id="billing_first_name">
                            </p>
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <!-- Your Order -->
                    <div class="col-md-4">
                        <div class="order-review-wrap ecommerce-checkout-review-order" id="order_review">
                            <h2 class="heading uppercase bottom-line full-grey">Your Order</h2>
                            <table class="table shop_table ecommerce-checkout-review-order-table">
                                <tbody>
                                    <tr class="order-total">
                                        <th><strong>Order Total</strong></th>
                                        <td>
                                            <strong><span class="amount">Rp. {{number_format($orders->grand_total)}}</span></strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Payment method -->
                            <div id="payment" class="ecommerce-checkout-payment">
                                <h2 class="heading uppercase bottom-line full-grey">Payment Method</h2>
                                <ul class="payment_methods methods">
                                    <li class="payment_method_bacs">
                                        <input id="payment_method_bacs" type="radio" class="input-radio" name="payment_method" value="bacs" checked="checked">
                                        <label for="payment_method_bacs">Direct Bank Transfer</label>
                                        <div class="payment_box payment_method_bacs">
                                            <p>Make your payment directly into our bank account. Please use your Order
                                                ID as the payment reference. Your order wont be shipped until the funds
                                                have cleared in our account.</p>
                                            <p>Recipient : {{$about->in_name}}</p>
                                            <p>Account number : {{$about->account_number}}</p>
                                        </div>
                                    </li>
                                </ul>

                                <div class="form-row place-order">
                                    <input type="submit" name="ecommerce_checkout_place_order" class="btn btn-lg btn-dark" id="place_order" value="Place order">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection


@push('js')
<script>
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
    })
</script>
@endpush