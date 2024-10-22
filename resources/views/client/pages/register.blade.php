@extends('client.layouts.master')

@section('content')
    @include('client.components.breadcrumd', ['title' => 'Register', 'category' => null])

    <section class=" section-10">
        <div class="container">
            <div class="login-form">
                <form action="" method="post" id="registerForm">
                    <h4 class="modal-title">Register Now</h4>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Name" id="name" name="name">
                        <p id="error"></p>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Email" id="email" name="email">
                        <p id="error"></p>
                    </div>
                    <div class="form-group position-relative">
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                        <i class="far fa-eye position-absolute end-0 top-50 translate-middle-y cursor-pointer text-muted p-2"
                            id="togglePassword"></i>
                        <p id="error"></p>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Confirm Password" id="cpassword"
                            name="cpassword">
                        <p id="error"></p>
                    </div>
                    <div class="form-group small">
                        <a href="#" class="forgot-link">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn btn-dark btn-block btn-lg" value="Register">Register</button>
                </form>
                <div class="text-center small">Already have an account? <a href="{{ route('login') }}">Login Now</a></div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            // Initially hide the toggle icon
            togglePassword.style.display = 'none';

            // Show/hide toggle icon based on password field's value
            password.addEventListener('input', function() {
                if (password.value.length > 0) {
                    togglePassword.style.display = 'block';
                } else {
                    togglePassword.style.display = 'none';
                }
            });

            // Toggle password visibility
            togglePassword.addEventListener('click', function() {
                // Toggle the type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);

                // Toggle the eye slash icon
                this.classList.toggle('fa-eye-slash');
            });
        });


        $("#registerForm").submit(function(e) {
            e.preventDefault();
            var element = $(this);
            $.ajax({
                type: "POST",
                url: "{{ route('pocess-register') }}",
                data: element.serialize(),
                cache: false,
                success: function(response) {
                    if (response.status) {
                            window.location.href = response.url;
                    } else {
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
