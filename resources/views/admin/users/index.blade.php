@extends('admin.layouts.master')

@section('title')
    Danh sách người dùng
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Thêm mới (+)</a>
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
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="myTable">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th width="100">Created</th>
                                <th width="100">Action</th>
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
            ajax: "{{ route('admin.users.index') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'role',
                    name: 'role'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        })

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
                        url: "{{ route('admin.users.destroy') }}",
                        method: "DELETE",
                        dataType: "json",
                        data: {
                            id: id
                        },
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
