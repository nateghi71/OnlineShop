@extends('layouts.home')

@section('script')
    <script type="module">
        function filter() {
            let attributes = @json($attributes);
            attributes.map(attribute => {

                let valueAttribute = $(`#attributeOption-${attribute.id}:checked`).map(function() {
                    return this.value;
                }).get().join('-');

                if (valueAttribute == "") {
                    $(`#filter-attribute-${attribute.id}`).prop('disabled', true);
                } else {
                    $(`#filter-attribute-${attribute.id}`).val(valueAttribute);
                }

            });

            let sortBy = $('#sort-by').val();
            if (sortBy == "default") {
                $('#filter-sort-by').prop('disabled', true);
            } else {
                $('#filter-sort-by').val(sortBy);
            }

            let search = $('#search-input').val();
            if (search == "") {
                $('#filter-search').prop('disabled', true);
            } else {
                $('#filter-search').val(search);
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
        $('[id^=attributeOption-]').on('change' , filter);
        $('#search-btn').on('click' , filter);
    </script>
@endsection

@section('content')
    @if(!isset($searchTag))
    <div class="col-md-3">
        <aside class="js-fullHeight bg-light border-end">
            <div class="px-2 pt-3 d-flex">
                <input class="form-control me-2" id="search-input" type="search" placeholder="Search" aria-label="Search"
                value="{{ request()->has('search') ? request()->search : '' }}">
                <button class="btn btn-success" id="search-btn" type="button">جستوجو</button>
            </div>
            <hr>
            <div class="ps-4 pt-3">
                <h5> زیر دسته
                    ({{$category->parent->name}})
                </h5>
                <div>
                    <ul class="list-unstyled pb-2 m-0">
                        <li class="px-5 py-2">

                        </li>
                        @foreach($category->parent->children as $cat)
                            <li class="px-5 py-2">
                                <a href="#" class="text-decoration-none text-primary"> {{$cat->name}} </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <hr>
            @foreach($attributes as $attribute)
                <div class="ps-4">
                    <h4> {{$attribute->name}} </h4>
                    <div>
                        <ul class="list-unstyled pb-2 m-0">
                            @foreach($attribute->attributeOptions as $attributeOption)
                                <li class="px-5 py-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $attributeOption->value }}"
                                               id="attributeOption-{{$attribute->id}}"
                                            {{ request()->has('attribute.' . $attribute->id) && in_array($attributeOption->value, explode('-', request()->attribute[$attribute->id])) ? 'checked' : '' }}>>
                                        <label class="form-check-label" for="attributeOption-{{$attributeOption->id}}">
                                            {{$attributeOption->value}}
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @if(!$loop->last)
                    <hr>
            @endif
            @endforeach
        </aside>
    </div>
    @endif
    <div class="{{isset($searchTag) ? 'col-md-12' : 'col-md-9'}}">
        <div class="row py-3 border-bottom">
            <div class="col-md-6">
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
        <div class="row mt-3">
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
        @foreach ($attributes as $attribute)
            <input id="filter-attribute-{{ $attribute->id }}" type="hidden" name="attribute[{{ $attribute->id }}]">
        @endforeach
        <input id="filter-sort-by" type="hidden" name="sortBy">
        <input id="filter-search" type="hidden" name="search">
    </form>

@endsection
