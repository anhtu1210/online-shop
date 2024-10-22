@extends('client.layouts.master')

@section('content')
    @include('client.components.breadcrumd', ['title' => 'Login', 'category' => null])

    <section class="section-10">
        <div class="v-container">
            <h2>OTP Verification</h2>

            <p>
                Please type verification code sent to
                <span id="email">
                    (email@example.com)
                </span>
            </p>

            <p>
                The OPT will expire in <span id="expire">30</span> s
            </p>

            <form action="" method="post">
                <div class="v-row">
                    <input id="input" name="otp" type="number" />
                    <input id="input" name="otp" type="number" disabled />
                    <input id="input" name="otp" type="number" disabled />
                    <input id="input" name="otp" type="number" disabled />
                </div>

                <button id="button" type="submit" class="btn btn-dark btn-block btn-sm">Verify OTP</button>
            </form>

            <p>
                Didn't receive the code?
                <a href="javascript:void(0)" id="request">Request Again!</a>
            </p>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        const inputs = document.querySelectorAll('#input'),
            button = document.querySelector('#button'),
            expire = document.querySelector('#expire'),
            email = document.querySelector('#email');

        generateOTPs();

        function generateOTPs() {
            inputs[0].focus();
            expire.innerText = 60;
            const expireInterval = setInterval(() => {
                expire.innerText--;

                if (expire.innerText === '0') {
                    clearInterval(expireInterval);
                }
            }, 1000);
        }
        button.setAttribute('disabled', true);
        inputs.forEach((input, index) => {
            input.addEventListener('keyup', (e) => {
                const currentIndex = input,
                    nextInput = input.nextElementSibling;
                prevInput = input.previousElementSibling;
                if (nextInput && nextInput.hasAttribute('disabled') && currentIndex.value !== "") {
                    nextInput.removeAttribute('disabled');
                    nextInput.focus();
                }

                if (e.key === 'Backspace') {
                    inputs.forEach((input, index1) => {
                        if (index <= index1 && prevInput) {
                            input.setAttribute('disabled', true);
                            prevInput.focus();
                            prevInput.value = "";
                        }
                        if(inputs[3].disabled && inputs[3].value !== ""){
                            inputs[3].blur();
                            button.classList.add('active');
                            return;
                        }

                    })
                }

                if (inputs[3].disabled && inputs[3].value !== "") {
                    inputs[3].blur();
                    button.classList.add('active');
                    return;
                }

                button.classList.remove('active');

            })
        });
    </script>
@endsection

@section('styles')
    <style>
        .v-container {
            background: #fff;
            width: 400px;
            border-radius: 30px;
            padding: 25px;
            text-align: center;
            margin: 0 auto;
        }

        .v-row {
            display: flex;
            gap: 30px;
            justify-content: center;
            margin: 20px;
        }

        .v-row input {
            height: 50px;
            width: 50px;
            padding: 5px;
            font-style: 25px;
            text-align: center;
            border-radius: 10px;
            outline: none;
            border: 1px solid #a3a3a3;
        }

        input::-webkit-inner-spin-button,
        input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
@endsection
