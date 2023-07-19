{{-- khai báo trang master --}}
@extends('front.layout.master')

{{-- thêm section chứa tên riêng của mỗi trang --}}
@section('title', 'Login')


{{-- khai báo thân --}}
@section('body')

    {{-- breadcrumb Section Begin --}}
    <div class="breacrumb-section">
        <div class="container">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="#"><i class="fa fa-home"></i>Home</a>
                    <span>Login</span>
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
                    <div class="login-form">
                        <h2>Login</h2>
                        <form action="" method="post">

                            @csrf
                            <div class="group-input">
                                <label for="email">Email address *</label>
                                <input type="email" id="email" name="email">
                            </div>

                            <div class="group-input">
                                <label for="pass">Password *</label>
                                <input type="password" id="pass" name="password">
                            </div>

                            <div class="group-input gi-check">
                                <div class="gi-more">
                                    <label for="save-pass" >
                                        Save Password
                                        <input type="checkbox" id= "save-pass" name="remember" >
                                        <span class="checkmark"></span>
                                    </label>
                                    <a href="#" class="forget-pass">Forger your Password</a>
                                </div>
                            </div>
                            <button type="submit" class="site-btn login-btn">Sign In</button>
                        </form>

                        <div class="switch-login">
                            <a href="register.html" class="or-login">
                                Or Create An Account
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>



    {{-- Register Section Begin End --}}


@endsection
