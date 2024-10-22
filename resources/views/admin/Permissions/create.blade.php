
@extends('admin.layouts.master')


@section('title')
    Thêm mới quyền
@endsection


@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Permission</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="permissionForm" name="permissionForm">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control" placeholder="Name">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
@endsection

@section('scripts')
    <script>
        $('#permissionForm').submit(function(e) {
            e.preventDefault();
            var element = $(this);
            $.ajax({
                url: "{{ route('admin.permissions.store') }}",
                method: "post",
                data: element.serialize(),
                dataType: "json",
                success: function(res) {


                    if (res.status) {
                        window.location.href = "{{ route('admin.permissions.index') }}"
                    }

                    if (res.errors && res.errors['name']) {

                        $('#name').addClass('is-invalid').siblings('p').addClass(
                            'invalid-feedback').html(res.errors.name)
                    } else {
                        $('#name').removeClass(
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
