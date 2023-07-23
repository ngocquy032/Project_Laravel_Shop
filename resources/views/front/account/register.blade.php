{{-- khai báo trang master --}}
@extends('front.layout.master')

{{-- thêm section chứa tên riêng của mỗi trang --}}
@section('title', 'Register')


{{-- khai báo thân --}}
@section('body')

    {{-- breadcrumb Section Begin --}}
    <div class="breacrumb-section">
        <div class="container">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="#"><i class="fa fa-home"></i>Home</a>
                    <span>Register</span>
                </div>
            </div>
        </div>
    </div>

    {{-- breadcrumb Section End --}}

    {{-- Register Section Begin --}}

    <div class="register-login-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="register-form">
                        <h2>Register</h2>

                        @if (session('notification'))
                            <div class="alert alert-warning" role="alert">
                                {{ session('notification') }}
                            </div>
                        @endif

                        <form action="" method="post">
                            @csrf
                            <div class="group-input">
                                <label for="name">Name *</label>
                                <input type="text" id="name" name="name">
                            </div>
                            <div class="group-input">
                                <label for="email">Email address *</label>
                                <input type="email" id="email" name="email">
                            </div>
                            <div class="group-input">
                                <label for="pass">Password *</label>
                                <input type="password" id="pass" name="password">
                            </div>
                            <div class="group-input">
                                <label for="con-pass">Confirm Password *</label>
                                <input type="password" id="con-pass" name="password_confirmation">
                            </div>
                            <button type="submit" class="site-btn register-btn">Sign Up</button>
                        </form>
                        <div class="switch-login">
                            <a href="./account/login" class="or-login">Or Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Register Section Begin End --}}

@endsection
