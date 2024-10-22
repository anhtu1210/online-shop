<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('home') }}">Home</a></li>
                @if (!is_null($category))

                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('shop') }}">{{ $title }}</a>
                    </li>
                    <li class="breadcrumb-item">{{ $category->name ?? $category }}</li>
                @else
                
                    <li class="breadcrumb-item">{{ $title }}</li>
                @endif

            </ol>
        </div>
    </div>
</section>
