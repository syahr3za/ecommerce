@extends('layout.home')

@section('content')
<!-- Contact -->
<section class="section-wrap contact pb-40">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mb-40">
                <form id="contact-form" action="#">
                    <div class="contact-name">
                        <input name="name" id="name" type="text" placeholder="Name*">
                    </div>
                    <div class="contact-email">
                        <input name="mail" id="mail" type="email" placeholder="E-mail*">
                    </div>
                    <div class="contact-subject">
                        <input name="subject" id="subject" type="text" placeholder="Subject">
                    </div>
                    <textarea name="comment" id="comment" placeholder="Message" rows="9"></textarea>
                    <input type="submit" class="btn btn-lg btn-dark btn-submit" value="Send message" id="submit-message">
                    <div id="msg" class="message"></div>
                </form>
            </div>
            <!-- Contact us -->
            <div class="col-md-3 col-md-offset-1 col-sm-5 mb-40">
                <div class="contact-item">
                    <h6>Address</h6>
                    <address>{{$about->title}}<br>
                        {{$about->address}}
                    </address>
                </div>
                <div class="contact-item">
                    <h6>Information</h6>
                    <ul>
                        <li>
                            <i class="fa fa-envelope"></i><a href="mailto:{{$about->email}}">{{$about->email}}</a>
                        </li>
                        <li>
                            <i class="fa fa-phone"></i><span>{{$about->telephone}}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection