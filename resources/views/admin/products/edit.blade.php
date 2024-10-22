@extends('admin.layouts.master')

@section('title')
    Cập nhật sản phẩm
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="productForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title">Title</label>
                                            <input type="text" value="{{ $product->title }}" onkeyup="ChangeToSlug()"
                                                name="title" id="title" class="form-control slug" placeholder="Title">
                                            <p id="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title">Slug</label>
                                            <input type="text" value="{{ $product->slug }}" name="slug" readonly
                                                id="slug" class="form-control convert_slug" placeholder="Slug">
                                            <p id="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="10" class="summernote"
                                                placeholder="Description">{{ $product->description }}</textarea>
                                            <p id="error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Pricing</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="price">Price</label>
                                            <input type="text" name="price" value="{{ $product->price }}"
                                                id="price" class="form-control" placeholder="Price">
                                            <p id="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="compare_price">Price Sale</label>
                                            <input type="text" name="price_sale" {{ $product->price_sale }} id="price_sale"
                                                class="form-control" placeholder="Price Sale">
                                            <p class="text-muted mt-3">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Inventory</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku">SKU (Stock Keeping Unit)</label>
                                            <input value="{{ $product->sku }}" type="text" name="sku" id="sku"
                                                class="form-control" placeholder="sku">
                                            <p id="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="barcode">Barcode</label>
                                            <input value="{{ $product->barcode }}" type="text" name="barcode"
                                                id="barcode" class="form-control" placeholder="Barcode">
                                            <p id="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="hidden" name="track_qty" value="No">
                                                <input class="custom-control-input" type="checkbox" id="track_qty"
                                                    name="track_qty" value="Yes"
                                                    {{ $product->track_qty == 'Yes' ? 'checked' : '' }}>
                                                <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                                <p id="error"></p>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input value="{{ $product->qty }}" type="number" min="0"
                                                name="qty" id="qty" class="form-control" placeholder="Qty">
                                            <p id="error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Block
                                        </option>
                                    </select>
                                    <p id="error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h2 class="h4  mb-3">Product category</h2>
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option value="" selected disabled>Select a category</option>
                                        @foreach ($categories as $cat)
                                            @include('admin.categories.partials.option', [
                                                'category' => $cat,
                                                'level' => 0,
                                                'selected' => $product->category_id,
                                            ])
                                        @endforeach
                                    </select>
                                    <p id="error"></p>
                                </div>

                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product brand</h2>
                                <div class="mb-3">
                                    <select name="brand_id" id="brand" class="form-control">
                                        <option value="" disabled selected>Select a brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ $brand->id == $product->brand_id ? 'selected' : '' }}>
                                                {{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Featured product</h2>
                                <div class="mb-3">
                                    <select name="is_featured" id="is_featured" class="form-control">
                                        <option value="No" {{ $product->is_featured == 'No' ? 'selected' : '' }}>No
                                        </option>
                                        <option value="Yes" {{ $product->is_featured == 'Yes' ? 'selected' : '' }}>Yes
                                        </option>
                                    </select>
                                    <p id="error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Show on home</h2>
                                <div class="mb-3">
                                    <select name="is_show_home" id="is_show_home" class="form-control">
                                        <option value="No" {{ $product->is_show_home == 'No' ? 'selected' : '' }}>No</option>
                                        <option value="Yes" {{ $product->is_show_home == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    <p id="error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body pb-0">
                                <h2 class="h4 mb-3">Image</h2>
                                <div class="mb-3">
                                    <img src="{{ asset('images/products/' . $product->galleries->first()->image) }}"
                                        alt="" id="image_main" class="img-fluid w-100 mb-3">
                                    <a href="#" id="select_main_image" style="text-decoration: underline">Chọn ảnh
                                        tiêu biểu</a>

                                    <input type="file" name="image" id="image" class="form-control"
                                        style="display: none">
                                    <p id="error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body pb-0">
                                <h2 class="h4 mb-3">Image Gallery</h2>
                                <div class="mb-3">
                                    <div class="row" id="gallery-row">
                                        @if ($product->galleries->isNotEmpty())
                                            @foreach ($product->galleries->skip(1) as $gallery)
                                            <div class="col-4 gallery-image">
                                                    <input type="hidden" name="ids[]" value="{{ $gallery->id }}">
                                                    <img src="{{ asset('images/products/' . $gallery->image) }}"
                                                        alt="" class="img-fluid w-100 mb-3">

                                                    <button class="delete-btn btn btn-sm btn-danger">X</button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <a href="#" id="select_gallery_image" style="text-decoration: underline">Chọn
                                        ảnh thư viện</a>
                                    <input type="file" name="image_gallery[]" id="input_gallery_image"
                                        class="form-control" style="display: none" multiple>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let galleryImages = [];

            $('#select_main_image').click(function(e) {
                e.preventDefault();
                $('#image').click();
            });

            $('#select_gallery_image').click(function(e) {
                e.preventDefault();
                $('#input_gallery_image').click();
            });

            $('#image').change(function() {
                const file = $(this)[0].files[0];
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#image_main').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            });

            $('#input_gallery_image').change(function() {
                const files = $(this)[0].files;

                // Kiểm tra số lượng ảnh hiện tại trong galleryImages
                if (galleryImages.length + files.length > 9) {
                    alert('Bạn chỉ có thể chọn tối đa 9 ảnh.');
                    return;
                }

                // Thêm các file ảnh vào galleryImages và hiển thị trên giao diện
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    galleryImages.push(file);
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgElement = $('<img>').attr('src', e.target.result).addClass(
                            'w-100 preview-image img-thumbnail');
                        const deleteBtn = $('<button>').addClass('delete-btn btn btn-sm btn-danger')
                            .text('X');
                        const galleryImage = $('<div>').addClass('col-4 gallery-image').append(
                            imgElement, deleteBtn);
                        $('#gallery-row').append(galleryImage);
                    };
                    reader.readAsDataURL(file);
                }
            });

            $('#gallery-row').on('click', '.delete-btn', function() {
                const index = $(this).closest('.gallery-image').index();
                galleryImages.splice(index, 1); // Xóa ảnh khỏi mảng galleryImages

                // Xóa phần tử trong DOM
                $(this).closest('.gallery-image').remove();
            });

            $('#productForm').submit(function(e) {
                e.preventDefault();
                let data = new FormData(this);


                // Thêm ảnh hiện tại
                if ($('#image').val()) {
                    data.append('image', $('#image')[0].files[0]);
                }

                // Thêm các file ảnh đã chọn vào FormData
                for (let i = 0; i < galleryImages.length; i++) {
                    data.append('gallery_images[]', galleryImages[i]);
                }

                $.ajax({
                    url: "{{ route('admin.products.update', $product->id) }}",
                    method: "POST",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status) {
                            window.location.href = "{{ route('admin.products.index') }}";
                        }

                        $('#error').removeClass('invalid-feedback').html('');
                        $("input[type='text'], select, input[type='file']").removeClass(
                            'is-invalid');

                        $.each(response.errors, function(index, element) {
                            $(`#${index}`).addClass('is-invalid').siblings('p')
                                .addClass(
                                    'invalid-feedback').html(element);
                        });
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });
        });
    </script>
@endsection
