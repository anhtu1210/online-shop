@extends('admin.layouts.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update User</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="" method="post" id="userForm">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" value="{{ $user->name }}" name="name" id="name"
                                        class="form-control" placeholder="Name">
                                    <p id="error_name"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input type="text" value="{{ $user->email }}" name="email" id="email"
                                        class="form-control" placeholder="Email">
                                    <p id="error_name"></p>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone">Address</label>
                                    <input type="text" value="{{ $user->address }}" name="address" id="address"
                                        class="form-control" placeholder="Address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" value="{{ $user->phone }}" name="phone" id="phone"
                                        class="form-control" placeholder="Phone Number">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="phone">Role</label>
                                    @if ($roles->isNotEmpty())
                                        <div class="row">
                                            @foreach ($roles as $key => $role)
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" @checked(in_array($role->name, $user->roles->pluck('name')->toArray()))
                                                            type="checkbox" name="roles[]"
                                                            id="flexCheckDefault{{ $key }}"
                                                            value="{{ $role->name }}">
                                                        <label class="form-check-label"
                                                            for="flexCheckDefault{{ $key }}">
                                                            {{ $role->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <p id="error"></p>
                                    @endif
                                    <p id="error_name"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
        </form>
        </div>
    </section>
@endsection


@section('scripts')
    <script>
        $('#userForm').submit(function(e) {
            e.preventDefault();
            var element = $(this);

            $.ajax({
                type: "PUT",
                url: "{{ route('admin.users.update', $user->id) }}",
                data: element.serialize(),
                cache: false,
                success: function(response) {
                    if (response.status) {
                        window.location.href = "{{ route('admin.users.index') }}";
                    } else {
                        $('input[type="text"], select, input[type="password"]').removeClass(
                            'is-invalid');
                        $('#error').removeClass('invalid-feedback').html('');

                        $.each(response.errors, function(index, element) {
                            $(`#${index}`).addClass('is-invalid').siblings('p')
                                .addClass(
                                    'invalid-feedback').html(element);
                        });
                    }
                }
            });

        })
    </script>
@endsection
