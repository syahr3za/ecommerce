@extends('layout.app')
@section('title')
About
@endsection

@section('content')
<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">
            Data About
        </h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-about" method="POST" enctype="multipart/form-data" action="/abouts/{{$about->id}}">
                    @csrf
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Title" required value="{{$about->title}}">
                    </div>
                    <img src="/uploads/{{$about->logo}}" alt="" width="200">
                    <div class="form-group">
                        <label>Logo</label>
                        <input type="file" class="form-control" name="logo">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" placeholder="Description" class="form-control" id="" cols="30" rows="10" required>{{$about->description}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" placeholder="Address" class="form-control" id="" cols="30" rows="10" required>{{$about->address}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" placeholder="Email" required value="{{$about->email}}">
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" name="telephone" placeholder="Phone Number" required value="{{$about->telephone}}">
                    </div>
                    <div class="form-group">
                        <label>In Name</label>
                        <input type="text" class="form-control" name="in_name" placeholder="In Name" required value="{{$about->in_name}}">
                    </div>
                    <div class="form-group">
                        <label>Account Number</label>
                        <input type="text" class="form-control" name="account_number" placeholder="Account Number" required value="{{$about->account_number}}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection