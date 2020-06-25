@extends('layouts.app')

@section('content')
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="login-brand">
                    <h5>Welcome</h5>
                </div>

                <div class="card card-primary">
                    <div class="card-header"><h4>Login</h4></div>

                    <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                        @csrf
                        <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                        <div class="invalid-feedback">
                            Please fill in your email
                        </div>
                        </div>

                        <div class="form-group">
                        <div class="d-block">
                            <label for="password" class="control-label">Password</label>
                            <div class="float-right">
                            <a href="auth-forgot-password.html" class="text-small">
                                Forgot Password?
                            </a>
                            </div>
                        </div>
                        <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                        <div class="invalid-feedback">
                            please fill in your password
                        </div>
                        </div>

                        <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                            <label class="custom-control-label" for="remember-me">Remember Me</label>
                        </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" id="login">
                                Login
                            </button>
                            <a class="btn btn-outline-secondary btn-lg btn-block" tabindex="4">
                                Register
                            </a>
                        </div>
                    </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')

<script>
    (function($){

        $.fn.extend({ 

            addTemporaryClass: function(className, duration) {
                var elements = this;
                setTimeout(function() {
                    elements.removeClass(className);
                }, duration);

                return this.each(function() {
                    $(this).addClass(className);
                });
            }
        });

    })(jQuery);

    $(".btn").click(function() {
        // $(this).addClass("btn-progress").delay( 1000 );
        $(this).addTemporaryClass("btn-progress", 1000);
    });
</script>

@endsection
