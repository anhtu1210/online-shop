@extends('admin.layouts.master')

@section('content')
    {{-- <div>
        <div class="img-container">
            <div class="row"></div>
            <div class="col-md-6">
                <img id="profile-img" class="rounded mx-auto d-block">
            </div>

            <label class="label custom-file-upload btn btn-primary">
                <input type="file" class="d-none" id="file-input" name="image_url">
                <i class="fa fa-cloud-upload"></i> Upload image
            </label>

            <button type="button" class="btn btn-primary" id="saveAndUpload">Save</button>
        </div>
    </div>
    </div> --}}

    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Banner</h1>
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
            <form action="{{ route('admin.banners.store') }}" method="post" id="brandForm" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="name">Image Url</label>
                                <input type="file" name="image_url" id="file-input" class="d-none" class="form-control">
                                <div class="img-container mb-3">
                                    <img id="profile-img" src="{{ asset('images/banner-default.jpg') }}"
                                        class="rounded img-fluid" alt="" style="cursor: pointer">
                                    @error('image_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Title">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="link">Link</label>
                                    <input type="text" name="link" class="form-control" placeholder="Link">
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
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary" type="submit">Create</button>
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
    {{-- <script src="{{ asset('admin-assets/plugins/cropperjs-main/dist/cropper.min.js') }}"></script>
    <script>
        $(function() {

            var image = $('#profile-img')[0];

            var cropper;

            $('#file-input').on('change', function(e) {
                var files = e.target.files;

                if (files && files.length > 0) {

                    let file = files[0];

                    reader = new FileReader();

                    reader.onload = function(e) {
                        image.src = e.target.result;

                        cropper = new Cropper(image, {

                            aspectRatio: 1,

                            viewMode: 3,
                        })
                    }

                    reader.readAsDataURL(file);
                }
            });


            $('#saveAndUpload').on('click', function() {
                var canvas;
                if (cropper) {
                    canvas = cropper.getCroppedCanvas({
                        width: 160,
                        height: 160
                    })

                    var imageData = canvas.toDataURL();

                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.banners.store') }}",
                        data: {
                            image_url: imageData
                        },
                        success: function(response) {
                            if (response.status) {
                                window.location.href = "{{ route('admin.banners.index') }}";
                            }
                        },

                        error: function(err) {
                            console.log(err);
                        }

                    })

                    $("#profile-img").attr('src', imageData);

                    cropper.destroy();
                }
            });
        })
    </script> --}}
@endsection

@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('admin-assets/plugins/cropperjs-main/dist/cropper.min.css') }}"> --}}
@endsection
