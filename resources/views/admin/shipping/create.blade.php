@extends('admin.layouts.master')


@section('title')
    Thêm mới
@endsection


@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Shipping</h1>
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
                                                    {{ in_array($city->id, $shippingID) ? 'disabled' : '' }}>
                                                    {{ $city->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="amount" id="amount" class="form-control"
                                    placeholder="Amount">
                                <p></p>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a href="{{ route('admin.shipping.create') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>City</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($shippings->isNotEmpty())
                                        @foreach ($shippings as $shipping)
                                            <tr>
                                                <td>{{ $shipping->id }}</td>
                                                <td>{{ $shipping->name }}</td>
                                                <td>{{ $shipping->amount }}</td>
                                                <td>
                                                    <a href="{{ route('admin.shipping.edit', $shipping->id) }}"
                                                        class="btn btn-primary">Edit</a>
                                                    <a href="javascript:void(0)"
                                                        onclick="removeShipping('{{ $shipping->id }}')"
                                                        class="btn btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.table -->

        <!-- /.card -->


    </section>
@endsection

@section('scripts')
    <script>
        $('#shippingForm').submit(function(e) {
            e.preventDefault();
            var element = $(this);
            $.ajax({
                url: "{{ route('admin.shipping.store') }}",
                method: "post",
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

        function removeShipping(id) {
            Swal.fire({
                title: 'Bạn có chắc muốn xóa?',
                text: "Bạn sẽ không thể hoàn tác sau khi xóa!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.shipping.destroy', ':id') }}".replace(':id', id),
                        method: "delete",
                        success: function(res) {
                            console.log(res);
                            if (res.status) {
                                Swal.fire(res.message, '', 'success');

                                var _html = '';
                                $('tbody').empty();
                                res.shipping.forEach(element => {
                                    _html += `<tr>
                                        <td>${element.id}</td>
                                        <td>${element.name}</td>
                                        <td>${element.amount}</td>
                                        <td>
                                            <a href="{{ route('admin.shipping.edit', ':id') }}".replace(':id', element.id)
                                                class="btn btn-primary">Edit</a>
                                            <a href="javascript:void(0)"
                                                onclick="removeShipping('${element.id}')"
                                                class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>`
                                })

                                $('tbody').prepend(_html);
                            }
                        }
                    })
                }
            })
        }
    </script>
@endsection
