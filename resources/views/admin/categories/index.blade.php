@extends('admin.layouts.master')

@section('title')
    Danh Sách Danh Mục
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Danh mục</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Thêm mới (+)</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            @include('admin.message')
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap " id="myTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Parent</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
@endsection

@section('scripts')
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script>
        let table = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.categories.index') }}",
            columns: [
                { data: 'id', name: 'id' },
                {
                    data: 'image',
                    name: 'image'
                },
                { data: 'name', name: 'name' },
                { data: 'slug', name: 'slug' },
                { data: 'parent', name: 'parent' },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, full, meta) {
                        return data == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Block</span>';
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                }
            ],
            order: [
                [0, 'desc']
            ]
        });

        $('#myTable').on('click', '#removeItem', function() {
            let id = $(this).data('id');
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
                        url: "{{ route('admin.categories.destroy') }}",
                        method: "DELETE",
                        dataType: "json",
                        data: { id: id },
                        success: function(res) {
                            table.ajax.reload();
                            Swal.fire('Xóa thành công!', '', 'success');
                        },
                        error: function(xhr, status, error) {
                            console.error('Lỗi AJAX:', error);
                            Swal.fire('Có lỗi xảy ra!', '', 'error');
                        }
                    });
                }
            })
        })
    </script>
@endsection

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('admin-assets/css/dataTables.css') }}" />
@endsection
