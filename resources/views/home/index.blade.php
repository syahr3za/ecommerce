@extends('layout.home')

@section('content')
<!-- Hero Slider -->
<section class="hero-wrap text-center relative">
    <div id="owl-hero" class="owl-carousel owl-theme light-arrows slider-animated">
        @foreach ($sliders as $slider)
        <div class="hero-slide overlay" style="background-image:url(/uploads/{{$slider->image}})">
            <div class="container">
                <div class="hero-holder">
                    <div class="hero-message">
                        <h1 class="hero-title nocaps">{{$slider->slider_name}}</h1>
                        <h2 class="hero-subtitle lines">{{$slider->description}}</h2>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- Promo Banners -->
<section class="section-wrap promo-banners pb-30">
    <div class="container">
        <div class="row">
            @foreach ($categories as $category)
            <div class="col-xs-4 col-xxs-12 mb-30 promo-banner">
                <a href="/front/#">
                    <img src="/uploads/{{$category->image}}" alt="">
                    <div class="overlay"></div>
                    <div class="promo-inner valign">
                        <h2>{{$category->category_name}}</h2>
                        <span>{{$category->description}}</span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- Hot items -->
<section class="section-wrap-sm new-arrivals pb-50">
    <div class="container">
        <div class="row heading-row">
            <div class="col-md-12 text-center">
                <span class="subheading">Hot items of this year</span>
                <h2 class="heading bottom-line">
                    trendy products
                </h2>
            </div>
        </div>
        <div class="row items-grid">
            @foreach ($products as $product)
            <div class="col-md-3 col-xs-6">
                <div class="product-item hover-trigger">
                    <div class="product-img">
                        <a href="/front/shop-single.html">
                            <img src="/uploads/{{$product->image}}" alt="">
                        </a>
                        <div class="hover-overlay">
                            <div class="product-actions">
                                <a href="/front/#" class="product-add-to-wishlist">
                                    <i class="fa fa-heart"></i>
                                </a>
                            </div>
                            <div class="product-details valign">
                                <span class="category">
                                    <a href="/products/{{$product->subcategory_id}}">{{$product->subcategory->subcategory_name}}</a>
                                </span>
                                <h3 class="product-title">
                                    <a href="/product/{{$product->id}}">{{$product->product_name}}</a>
                                </h3>
                                <span class="price">
                                    <ins>
                                        <span class="amount">Rp. {{number_format($product->price)}}</span>
                                    </ins>
                                </span>
                                <div class="btn-quickview">
                                    <a href="/product/{{$product->id}}" class="btn btn-md btn-color">
                                        <span>More</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Testimony -->
<section class="section-wrap relative testimonials bg-parallax overlay" style="background-image:url(/front/img/testimonials/415-1920x485-blur_3.jpg);">
    <div class="container relative">
        <div class="row heading-row mb-20">
            <div class="col-md-6 col-md-offset-3 text-center">
                <h2 class="heading white bottom-line">Happy Clients</h2>
            </div>
        </div>
        <div id="owl-testimonials" class="owl-carousel owl-theme text-center">
            @foreach ($testimonies as $testimony)
            <div class="item">
                <div class="testimonial">
                    <p class="testimonial-text">{{$testimony->description}}</p>
                    <span>{{$testimony->testimony_name}}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection