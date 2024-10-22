@extends('admin.layouts.master')


@section('title')
    Cập nhật quyền hạn
@endsection


@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>cập nhật quyền hạn</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-primary">Back</a>
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
                <input type="hidden" name="id" value="{{ $role->id }}">

                <div class="form-group mb-3 w-50">
                    <label for="name">Name</label>
                    <div class="input-group ">
                        <input value="{{ old('name', $role->name) }}" type="text" name="name" id="name"
                            class="form-control" placeholder="Name">
                        <button id="all" type="submit" class="btn btn-outline-info ml-3">All Permissions</button>
                        <button id="reset" type="submit" class="btn btn-outline-secondary ml-3">Reset</button>
                    </div>
                    <p></p>
                </div>

                @if ($permissions->isNotEmpty())
                    <div class="row">
                        @foreach ($permissions as $key => $permission)
                            <div class="col-md-3">

                                <div class="form-check">
                                    <input {{ in_array($permission->name, $rolePrommissions) ? 'checked' : '' }}
                                        class="form-check-input" type="checkbox" name="permissions[]"
                                        id="flexCheckDefault{{ $key }}" value="{{ $permission->name }}">
                                    <label class="form-check-label" for="flexCheckDefault{{ $key }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif


                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
@endsection

@section('scripts')
    <script>
        $('#all').click(function(e) {
            e.preventDefault();
            $('input:checkbox').prop('checked', true);
        });
        $('#reset').click(function(e) {
            e.preventDefault();
            $('input:checkbox').prop('checked', false);
        });

        $('#permissionForm').submit(function(e) {
            e.preventDefault();
            var element = $(this);

            $.ajax({
                url: "{{ route('admin.roles.update', $role->id) }}",
                method: "put",
                data: element.serializeArray(),
                dataType: "json",
                success: function(res) {

                    if (res.status) {
                        window.location.href = "{{ route('admin.roles.index') }}"
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
