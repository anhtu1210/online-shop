@extends('client.layouts.master')

@section('content')
    @include('client.components.breadcrumd', ['title' => 'Login', 'category' => null])

    <section class="section-10">
        <div class="container">
            <div class="login-form">
                <p class="alert"></p>

                <form method="post" id="loginForm">
                    <h4 class="modal-title">Login to Your Account</h4>
                    <div class="form-group">
                        <input type="text" class="form-control" id="email" placeholder="Email" name="email">
                        <p id="error"></p>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                        <p id="error"></p>
                    </div>
                    <div class="form-group small">
                        <a href="#" class="forgot-link">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn btn-dark btn-block btn-lg">Login</button>
                </form>
                <div class="text-center small">Don't have an account? <a href="{{ route('register') }}">Sign up</a></div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $("#loginForm").submit(function(e) {
            e.preventDefault();
            var element = $(this);
            $.ajax({
                type: "POST",
                url: "{{ route('authenticate') }}",
                data: element.serialize(),
                cache: false,
                success: function(response) {
                    if (response.status) {
                        window.location.href = response.url;
                    } else {
                        if (response.message) {
                            $('.alert').addClass('alert-danger').html(response.message);
                        }
                        $('input[type="text"], input[type="password"]').removeClass('is-invalid');
                        $('#error').removeClass('invalid-feedback').html('');
                        $.each(response.errors, function(index, element) {
                            $(`#${index}`).addClass('is-invalid').siblings('p').addClass(
                                'invalid-feedback').html(element);
                        });
                    }
                }
            });
        });
    </script>
@endsection
