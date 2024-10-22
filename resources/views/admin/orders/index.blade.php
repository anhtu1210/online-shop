@extends('admin.layouts.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Orders</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('orders.export.all') }}" class="btn btn-primary">Invoice All</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="myTable">
                        <thead>
                            <tr>
                                <th>Orders #</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Date Purchased</th>
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
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script>
        let table = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.orders.index') }}",
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
                    data: 'phone_number',
                    name: 'phone_number'
                },

                {
                    data: 'status',
                    name: 'status',
                },
                {
                    data: 'total_price',
                    name: 'total_price',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                }

            ],
            order: [
                [0, 'desc']
            ]
        });
    </script>
@endsection

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('admin-assets/css/dataTables.css') }}" />
@endsection
