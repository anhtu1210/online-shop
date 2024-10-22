@extends('admin.layouts.master')


@section('title')
    Thêm mới danh mục
@endsection


@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="categoryForm" name="categoryForm">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input onkeyup="ChangeToSlug()" type="text" name="name" id="slug"
                                        class="form-control slug" placeholder="Name">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Slug</label>
                                    <input type="text" name="slug" id="convert_slug" readonly class="form-control convert_slug"
                                        placeholder="Slug">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="parent_id">Danh mục cha:</label>
                                    <select id="parent_id" name="parent_id" class="form-control">
                                        <option value="" selected disabled>---------- Chọn danh mục cha ----------</option>
                                        @foreach ($categories as $cat)
                                            @include('admin.categories.partials.option', [
                                                'category' => $cat,
                                                'level' => 0,
                                                'selected' => null
                                            ])
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <div>
                                        <input type="radio" name="status" value="1" id="" checked>
                                        <span class="mr-3">Active</span>
                                        <input type="radio" name="status" value="0" id="">
                                        <span>Block</span>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
@endsection

@section('scripts')
    <script>
        $('#categoryForm').submit(function(e) {
            e.preventDefault();
            var element = $(this);
            $.ajax({
                url: "{{ route('admin.categories.store') }}",
                method: "post",
                data: element.serialize(),
                dataType: "json",
                success: function(res) {

                    if (res.status) {
                        window.location.href = "{{ route('admin.categories.index') }}"
                    }

                    if (res.errors && res.errors['name']) {
                        $('#slug').addClass('is-invalid').siblings('p').addClass(
                            'invalid-feedback').html(res.errors.name)
                    } else {
                        $('#slug').removeClass(
                            'is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if (res.errors && res.errors['slug']) {
                        $('#convert_slug').addClass('is-invalid').siblings('p').addClass(
                            'invalid-feedback').html(res.errors.slug)
                    } else {
                        $('#convert_slug').removeClass(
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
