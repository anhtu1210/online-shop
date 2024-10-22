@extends('client.layouts.master')

@section('content')
    @if (session()->has('errors'))
        <div class="alert alert-danger">
            {{ session()->get('errors') }}
        </div>
    @endif
    <div class="site-section">
        <div class="container">
            <div class="my-3 bg-secondary border p-3 text-white">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <span class="icon-check_circle display-3 text-success"></span>
                        <h2 class="display-3 text-white">Thank you!</h2>
                        <p class="lead mb-5">You order was successfuly completed.</p>
                        <p><a href="{{ route('home') }}" class="btn btn-sm btn-primary">Back to shop</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
