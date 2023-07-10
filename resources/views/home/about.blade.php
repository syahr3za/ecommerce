@extends('layout.home')

@section('title', 'About')

@section('content')
<section class="section-wrap intro pb-0">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 mb-50">
                <h2 class="intro-heading">about our shop</h2>
                <p>{{$about->description}}</p>
            </div>
            
        </div>
        <hr class="mb-0">
    </div>
</section>

<!-- Promo Section -->


<!-- Testimony -->
<section class="section-wrap testimonials">
    <div class="container">
        <div class="row heading-row mb-20">
            <div class="col-md-6 col-md-offset-3 text-center">
                <span class="subheading">Hot Customers</span>
                <h2 class="heading bottom-line">Happy Clients</h2>
            </div>
        </div>
        <div id="owl-testimonials" class="owl-carousel owl-theme owl-dark-dots text-center">
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