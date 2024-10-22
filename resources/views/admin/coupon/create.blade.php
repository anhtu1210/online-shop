@extends('admin.layouts.master')


@section('title')
    Thêm mới Khuyến Mãi
@endsection


@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Coupons</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="discountForm" name="discountForm">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code">Code</label>
                                    <input type="text" name="code" id="code" class="form-control slug"
                                        placeholder="Coupon Code">
                                    <p id="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Name">
                                    <p id="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Max User</label>
                                    <input type="number" name="max_user" id="max_user" class="form-control"
                                        placeholder="Max User">
                                    <p id="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Max Users User</label>
                                    <input type="text" name="max-users-user" id="max-users-user" class="form-control"
                                        placeholder="Max User User">
                                    <p id="error"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Discount Amount</label>
                                    <input type="text" name="discount_amount" id="discount_amount" class="form-control"
                                        placeholder="Discount Amount">
                                    <p id="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Min Amount</label>
                                    <input type="number" name="min_amount" id="min_amount" class="form-control"
                                        placeholder="Min Amount">
                                    <p id="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_at">Starts At</label>
                                    <input type="text" name="start_at" id="start_at" class="form-control"
                                        placeholder="Starts At">
                                    <p id="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expires_at">Expires At</label>
                                    <input type="text" name="expires_at" id="expires_at" class="form-control"
                                        placeholder="Expires At">
                                    <p id="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">InActive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Type</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="percent">Percent</option>
                                        <option value="fixed">Fixed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Decription</label>
                                    <textarea name="description" id="description" cols="30" rows="5" class="form-control">
                                    </textarea>
                                    <p id="error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
        </form>
        </div>
        <!-- /.card -->
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#start_at').datetimepicker({
                format: 'Y-m-d H:i:s',
            });

            $('#expires_at').datetimepicker({
                format: 'Y-m-d H:i:s',
            });
        })
        $('#discountForm').submit(function(e) {
            e.preventDefault();
            var element = $(this);
            $.ajax({
                url: "{{ route('admin.coupons.index') }}",
                method: "post",
                data: element.serialize(),
                dataType: "json",
                success: function(response) {

                    if (response.status) {
                        window.location.href = "{{ route('admin.coupons.index') }}"
                    }


                    $('#error').removeClass('invalid-feedback').html('');
                    $("input[type='text'], select").removeClass(
                        'is-invalid');

                    $.each(response.errors, function(index, element) {
                        $(`#${index}`).addClass('is-invalid').siblings('p')
                            .addClass(
                                'invalid-feedback').html(element);
                    });


                },
                error: function(jqXHR, exception) {
                    console.log('Đã có lỗi xay ra trong quá trình truyền dữ liệu.');
                }
            })
        })
    </script>
@endsection
