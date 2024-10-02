@extends('frontend.homepage.layout')
@section('content')
    <div class="login-container">
        <div class="row">
            <div class="col-lg-7">
                <a class="thumb image img-cover">
                    <img src="{{ $system['background_lg'] }}" alt="">
                </a>
            </div>
            <div class="col-lg-5">
                <div class="mx-auto">
                    <h3 class="heading-2">Đăng nhập</h3>
                    <form action="{{ route('fe.auth.dologin') }}" class="form-login">
                        <div class="form-group mb15">
                            <label for="">Email</label>
                            <input 
                                type="text" 
                                name="email" 
                                class="form-control" 
                                placeholder="Email" 
                                value=""
                            >
                        </div>
                        <div class="form-group mb15">
                            <label for="">Password</label>
                            <input 
                                type="password" 
                                name="password" 
                                class="form-control" 
                                placeholder="Password" 
                                value=""
                            >
                        </div>
                        <button type="submit" class="btn btn-success block full-width m-b">Đăng nhập</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection



