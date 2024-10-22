@extends('admin.layouts.master')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update Banner</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="{{ route('admin.banners.update', $banner->id) }}" method="post" id="brandForm"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="name">Image Url</label>
                                <input type="file" name="image_url" id="file-input" class="d-none" class="form-control">
                                <div class="img-container mb-3">
                                    <img id="profile-img" src="{{ asset('images/banners/' . $banner->image_url) }}"
                                        class="rounded img-fluid" alt="" style="cursor: pointer">
                                    @error('image_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" value="{{ old('title', $banner->title) }}"
                                        class="form-control" placeholder="Title">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="link">Link</label>
                                    <input type="text" value="{{ old('link', $banner->link) }}" name="link"
                                        class="form-control" placeholder="Link">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <div>
                                        <input type="radio" name="status" value="1" id=""
                                            @checked(old('status', $banner->status == 1))>
                                        <span class="mr-3">Active</span>
                                        <input type="radio" name="status" value="0" id=""
                                            @checked(old('status', $banner->status == 0))>
                                        <span>Block</span>
                                    </div>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary" type="submit">Update</button>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
@endsection

@section('scripts')
    <script>
        $(function() {
            $("#profile-img").on("click", function() {
                $("#file-input").click();
            });

            $("#file-input").on("change", function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $("#profile-img").attr("src", e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection
