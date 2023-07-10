@extends('layout.home')

@section('title', 'Product')

@section('content')
<!-- Single Product -->
<section class="section-wrap pb-40 single-product">
    <div class="container-fluid semi-fluid">
        <div class="row">
            <div class="col-md-6 col-xs-12 product-slider mb-60">
                <div class="flickity flickity-slider-wrap mfp-hover" id="gallery-main">
                    <div class="gallery-cell">
                        <a href="/uploads/{{$product->image}}" class="lightbox-img">
                            <img src="/uploads/{{$product->image}}" alt="" />
                            <i class="ui-zoom zoom-icon"></i>
                        </a>
                    </div>
                    <div class="gallery-cell">
                        <a href="/uploads/{{$product->image}}" class="lightbox-img">
                            <img src="/uploads/{{$product->image}}" alt="" />
                            <i class="ui-zoom zoom-icon"></i>
                        </a>
                    </div>
                    <div class="gallery-cell">
                        <a href="/uploads/{{$product->image}}" class="lightbox-img">
                            <img src="/uploads/{{$product->image}}" alt="" />
                            <i class="ui-zoom zoom-icon"></i>
                        </a>
                    </div>
                    <div class="gallery-cell">
                        <a href="/uploads/{{$product->image}}" class="lightbox-img">
                            <img src="/uploads/{{$product->image}}" alt="" />
                            <i class="ui-zoom zoom-icon"></i>
                        </a>
                    </div>
                    <div class="gallery-cell">
                        <a href="/uploads/{{$product->image}}" class="lightbox-img">
                            <img src="/uploads/{{$product->image}}" alt="" />
                            <i class="ui-zoom zoom-icon"></i>
                        </a>
                    </div>
                </div>
                <div class="gallery-thumbs">
                    <div class="gallery-cell">
                        <img src="/uploads/{{$product->image}}" alt="" />
                    </div>
                    <div class="gallery-cell">
                        <img src="/uploads/{{$product->image}}" alt="" />
                    </div>
                    <div class="gallery-cell">
                        <img src="/uploads/{{$product->image}}" alt="" />
                    </div>
                    <div class="gallery-cell">
                        <img src="/uploads/{{$product->image}}" alt="" />
                    </div>
                    <div class="gallery-cell">
                        <img src="/uploads/{{$product->image}}" alt="" />
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xs-12 product-description-wrap">
                <ol class="breadcrumb">
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li>
                        <a href="/products/{{$product->subcategory_id}}">{{$product->subcategory->subcategory_name}}</a>
                    </li>
                    <li class="active">
                        Catalog
                    </li>
                </ol>
                <h1 class="product-title">{{$product->product_name}}</h1>
                <span class="price">
                    <ins>
                        <span class="amount">Rp. {{number_format($product->price)}}</span>
                    </ins>
                </span>
                <p class="short-description">{{$product->description}}</p>

                <div class="color-swatches clearfix">
                    <span>Color:</span>
                    @php
                    $colors = explode(',',$product->color);
                    @endphp
                    @foreach ($colors as $color)
                    <input type="radio" name="color" id="{{$color}}" value="{{$color}}" class="color">
                    <label for="{{$color}}" style="margin-right: 20px">{{$color}}</label>
                    @endforeach
                </div>

                <div class="size-options clearfix">
                    <span>Size:</span>
                    @php
                    $sizes = explode(',',$product->size);
                    @endphp
                    @foreach ($sizes as $size)
                    <input type="radio" name="size" id="{{$size}}" value="{{$size}}" class="size">
                    <label for="{{$size}}" style="margin-right: 20px">{{$size}}</label>
                    @endforeach
                </div>

                <div class="product-actions">
                    <span>Qty:</span>
                    <div class="quantity buttons_added">
                        <input type="number" step="1" min="0" value="1" title="Qty" class="input-text qty text" />
                        <div class="quantity-adjust">
                            <a href="#" class="plus">
                                <i class="fa fa-angle-up"></i>
                            </a>
                            <a href="#" class="minus">
                                <i class="fa fa-angle-down"></i>
                            </a>
                        </div>
                    </div>
                    <input type="hidden" class="product-id" value="{{$product->id}}">
                    <span class="product-price" data-price="{{$product->price}}"></span>
                    <a href="#" class="btn btn-dark btn-lg add-to-cart"><span>Add to Cart</span></a>
                    <a href="#" class="product-add-to-wishlist"><i class="fa fa-heart"></i></a>
                </div>

                <div class="product_meta">
                    <span class="sku">SKU: <a href="#">{{$product->sku}}</a></span>
                    <span class="brand_as">Category: <a href="#">{{$product->category->category_name}}</a></span>
                    <span class="posted_in">Tags: <a href="#">{{$product->tags}}</a></span>
                </div>

                <!-- Description -->
                <div class="panel-group accordion mb-50" id="accordion">
                    <div class="panel">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="minus">Description<span>&nbsp;</span>
                            </a>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                {{$product->description}}
                            </div>
                        </div>
                    </div>

                    <!-- Product info -->
                    <div class="panel">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="plus">Information<span>&nbsp;</span>
                            </a>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table class="table shop_attributes">
                                    <tbody>
                                        <tr>
                                            <th>Size:</th>
                                            <td>{{$product->size}}</td>
                                        </tr>
                                        <tr>
                                            <th>Colors:</th>
                                            <td>{{$product->color}}</td>
                                        </tr>
                                        <tr>
                                            <th>Fabric:</th>
                                            <td>{{$product->material}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sosmed share -->
                <div class="socials-share clearfix">
                    <span>Share:</span>
                    <div class="social-icons nobase">
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-google"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Related Products -->
<section class="section-wrap pt-0 shop-items-slider">
    <div class="container">
        <div class="row heading-row">
            <div class="col-md-12 text-center">
                <h2 class="heading bottom-line">
                    Latest Products
                </h2>
            </div>
        </div>
        <div class="row">
            <div id="owl-related-items" class="owl-carousel owl-theme">
                @foreach ($latest_products as $product)
                <div class="product">
                    <div class="product-item hover-trigger">
                        <div class="product-img">
                            <a href="/product/{{$product->id}}">
                                <img src="/uploads/{{$product->image}}" alt="">
                                <img src="/uploads/{{$product->image}}" alt="" class="back-img">
                            </a>
                            <div class="product-label">
                                <span class="sale">sale</span>
                            </div>
                            <div class="hover-2">
                                <div class="product-actions">
                                    <a href="#" class="product-add-to-wishlist">
                                        <i class="fa fa-heart"></i>
                                    </a>
                                </div>
                            </div>
                            <a href="/product/{{$product->id}}" class="product-quickview">More</a>
                        </div>
                        <div class="product-details">
                            <h3 class="product-title">
                                <a href="/product/{{$product->id}}">{{$product->product_name}}</a>
                            </h3>
                            <span class="category">
                                <a href="/products/{{$product->subcategory_id}}">{{$product->subcategory->subcategory_name}}</a>
                            </span>
                        </div>
                        <span class="price">
                            <ins>
                                <span class="amount">Rp. {{number_format($product->price)}}</span>
                            </ins>
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection


@push('js')
<script>
    $(function(){
        $('.add-to-cart').click(function(e){
            var product_price = parseFloat($('.product-price').data('price'));
                member_id = {{Auth::guard('webmember')->user()->id}};
                product_id = $('.product-id').val();
                qty = $('.qty').val();
                size = $('input[name=size]:checked').val();
                color = $('input[name=color]:checked').val();
                total = product_price * qty;
                is_checkout = 0

            $.ajax({
                url : '/add_to_cart',
                method : "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}",
                },
                data : {
                    member_id,
                    product_id,
                    qty,
                    size,
                    color,
                    total,
                    is_checkout,
                },
                success : function(data){
                    window.location.href = '/cart'
                }
            });
        })
    })

</script>
@endpush