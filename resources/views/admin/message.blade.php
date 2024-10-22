@if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4><i class="icon fa fa-ban"></i> Thông báo!</h4>
        {{ session()->get('error') }}
    </div>
@endif

@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
        {{ session()->get('success') }}
    </div>
@endif
