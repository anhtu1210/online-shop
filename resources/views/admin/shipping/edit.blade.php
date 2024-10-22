@extends('admin.layouts.master')


@section('title')
    Cập nhật
@endsection


@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update Shipping</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.shipping.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        @include('admin.message')
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="shippingForm" name="shippingForm">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <select name="city_id" id="city_id" class="form-control">
                                        <option value="" disabled selected> Select a City </option>
                                        @if ($cities->isNotEmpty())
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}"
                                                    @selected($city->id == $shipping->city_id)
                                                    {{ in_array($city->id, $shippingID) ? 'disabled' : '' }}>
                                                    {{ $city->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="amount" id="amount" value="{{ $shipping->amount }}"
                                    class="form-control" placeholder="Amount">
                                <p></p>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('admin.shipping.create') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- /.card -->


    </section>
@endsection

@section('scripts')
    <script>
        $('#shippingForm').submit(function(e) {
            e.preventDefault();
            var element = $(this);
            $.ajax({
                url: "{{ route('admin.shipping.update', $shipping->id) }}",
                method: "put",
                data: element.serialize(),
                dataType: "json",
                success: function(res) {

                    if (res.status) {
                        window.location.href = "{{ route('admin.shipping.create') }}"
                    }

                    if (res.errors && res.errors['city_id']) {
                        $('#city_id').addClass('is-invalid').siblings('p').addClass(
                            'invalid-feedback').html(res.errors.city_id)
                    } else {
                        $('#city_id').removeClass(
                            'is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if (res.errors && res.errors['amount']) {
                        $('#amount').addClass('is-invalid').siblings('p').addClass(
                            'invalid-feedback').html(res.errors.amount)
                    } else {
                        $('#amount').removeClass(
                            'is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }


                },
                error: function(jqXHR, exception) {
                    console.log('Đã có lỗi xay ra trong quá trình truyền dữ liệu.');
                }
            })
        })
    </script>
@endsection
