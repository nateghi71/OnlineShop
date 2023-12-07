@extends('layouts.home')

@section('script')
    <script type="module">
        function filter() {
            let sortBy = $('#sort-by').val();
            if (sortBy == "default") {
                $('#filter-sort-by').prop('disabled', true);
            } else {
                $('#filter-sort-by').val(sortBy);
            }

            $('#filter-form').submit();
        }

        $('#filter-form').on('submit', function(event) {
            event.preventDefault();
            let currentUrl = '{{ url()->current() }}';
            let url = currentUrl + '?' + decodeURIComponent($(this).serialize())
            $(location).attr('href', url);
        });

        $('#sort-by').on('change' , filter);
    </script>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="row py-3 border-bottom">
            <div class="col-md-4">
                <select class="form-control" id="sort-by">
                    <option value="default"> مرتب سازی </option>
                    <option value="max"
                        {{ request()->has('sortBy') && request()->sortBy == 'max' ? 'selected' : '' }}>
                        بیشترین قیمت </option>
                    <option value="min"
                        {{ request()->has('sortBy') && request()->sortBy == 'min' ? 'selected' : '' }}> کم
                        ترین قیمت </option>
                    <option value="latest"
                        {{ request()->has('sortBy') && request()->sortBy == 'latest' ? 'selected' : '' }}>
                        جدیدترین </option>
                    <option value="oldest"
                        {{ request()->has('sortBy') && request()->sortBy == 'oldest' ? 'selected' : '' }}>
                        قدیمی ترین </option>
                </select>
            </div>
        </div>
        <div class="row m-3">
            @foreach($products as $product)
                <div class="col-md-3">
                    <div class="card mb-3">
                        <img class="card-img-top"
                             src="{{url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $product->images()->where('is_primary' , 1)->first()->image)}}"
                             alt="{{$product->name}}">
                        <div class="card-body text-center">
                            <a href="{{route('home.product.show' , ['product'=>$product->slug])}}" class="card-title text-decoration-none"><h5 class="text-start text-primary mb-3">{{$product->name}}</h5></a>
                            <p class="card-text text-danger d-flex justify-content-between">قیمت:<span>{{$product->delivery_amount}}</span></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $products->withQueryString()->links() }}
    </div>

    <form id="filter-form">
        <input id="filter-sort-by" type="hidden" name="sortBy">
    </form>

@endsection
