@extends('layouts.home')

@section('headers')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('script')
    <script type="module">
        let priceProduct = 0;
        $("select[id^='variations-']").on('change',changePrice)

        function changePrice(e){
            e.preventDefault();
            let formData = new FormData(this.form)
            $.ajax({
                method:"post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:this.form.action,
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache:false,
                success:function (response){
                    if(response.exist)
                    {
                        $('#quantity').attr('max' , response.quantity)
                        $('#quantity').val(1);
                        if(response.is_sale)
                        {
                            priceProduct = response.sale_price;
                            $('#showPrice').html(
                                '<span>' + response.sale_price + '</span>' + '->' +
                                '<span class="me-5 text-decoration-line-through">' + response.price + '</span>'
                            )
                        }
                        else
                        {
                            priceProduct = response.price;
                            $('#showPrice').html('<span>' + response.price + '</span>')
                        }
                    }
                    else
                    {
                        $('#quantity').attr('max' , 0)
                        $('#quantity').attr('min' , 0)
                        $('#quantity').val(0);
                        priceProduct = response.state;
                        $('#showPrice').html('<span>' + response.state + '</span>')
                    }
                },
                error:function (xhr, ajaxOptions, thrownError){
                    console.log("error: " + xhr.status)
                },
            })
        }

        $('#quantity').on('change' , function (){
            let quantity = $(this).val();
            let price = priceProduct;
            if(Number.isInteger(priceProduct))
                $('#showPrice').html('<span>' + (quantity * price) + '</span>');
        })

        $("select[id^='variations-']").trigger('change')
        $("#quantity").trigger('change')

    </script>
@endsection

@section('content')
    <div class="bg-body-secondary w-100 py-2 ps-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="" class="text-decoration-none">خانه</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none">{{$product->category->name}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
            </ol>
        </nav>
    </div>
<div class="row px-5" id="first-section">
    <div class="col-md-4 p-0 border-end border-opacity-50">
        <div class="text-center my-3">
            <img src="{{url(env('PRODUCT_IMAGES_UPLOAD_PATH')) . '/' .  $product->images()->where('is_primary' , 1)->first()->image }}"
            alt="{{$product->name}}" width="400" height="300">
        </div>
        <div class="p-3 bg-body-secondary text-center" data-bs-spy="scroll" data-bs-offset="0">
            @foreach($product->images->where('is_primary' , 0) as $image)
                <img src="{{url(env('PRODUCT_IMAGES_UPLOAD_PATH')) . '/' . $image->image }}"
                alt="{{$product->name}}" width="100" height="100">
            @endforeach
        </div>
    </div>
    <div class="col-md-8">
        <div class="d-flex justify-content-between border-bottom border-opacity-50">
            <h3 class="py-3">{{$product->name}}</h3>
            <div class="py-3" dir="ltr">
                @php $rating = 1.4; @endphp
                <span>
                @foreach(range(1,5) as $i)
                    @if($rating >0)
                        @if($rating >0.5)
                            <i class="fa fa-star"></i>
                        @else
                            <i class="fa fa-star-half-o"></i>
                        @endif
                    @else
                        <i class="fa fa-star-o"></i>
                    @endif
                        @php $rating--; @endphp
                @endforeach
                </span><br>
                <span>امتیاز : {{$rating}}</span><br>
                <span>دیدگاه : {{$rating}}</span>
            </div>
        </div>

        <ul class="list-unstyled">
            @foreach($product->attributeOptions->where('is_variation' , 0) as $attributeOption)
                <li class="mb-3">
                    <span class="mb-3">{{$attributeOption->attr->name}} :</span> <br>
                    <span class="ms-3">{{$attributeOption->value}}</span>
                </li>
            @endforeach
        </ul>
        <form action="{{route('home.product.setPrice' , ['product' => $product->id])}}" method="post">
            @csrf
            @php
                $attrs = $product->attributeOptions->where('is_variation' , 1)->groupBy('attribute_id');
            @endphp
            @foreach($attrs as $key => $attributeOptions)
                <diV class="col-md-3 mb3">
                    <label class="form-label">{{$attributeOptions->first()->attr->name}} :</label>
                    <select class="form-control" name="variations[]" id="variations-{{$key}}">
                        @foreach($attributeOptions as $attributeOption)
                            <option value="{{$attributeOption->id}}">{{$attributeOption->value}}</option>
                        @endforeach
                    </select>
                </diV>
            @endforeach

            <div class="col-md-3 mb3">
                <label class="form-label">تعداد :</label>
                <input class="form-control" type="number" name="quantity" id="quantity" max="5" min="1" />
            </div>

            <div class="d-flex justify-content-between">
                <h5 class="text-danger my-5">
                    <span class="ms-4">قیمت : </span>
                    <span class="ms-4" id="showPrice"></span>
                </h5>
                <div class="my-5">
                    <button class="btn btn-success mx-3" type="button">افزودن به سبد خرید</button>
                    <button class="btn btn-info" type="button">مقایسه</button>
                </div>
            </div>

        </form>

    <div class="ms-4">
        <span>تگ ها : </span>
        @foreach($product->tags as $tag)
            <span class="badge bg-secondary mx-2">
                <a href="{{route('home.product.search.tag' , ['tag' => $tag->slug])}}" class="text-decoration-none text-white">
                    {{$tag->name}}
                </a>
            </span>
        @endforeach
    </div>
    </div>
    <hr>
</div>
<div class="row mt-3 px-5" id="second-section">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#description">توضیحات</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#comments">کامنت ها</a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="description" class="tab-pane active">
            <p>{{$product->description}}</p>
        </div>
        <div id="comments" class="tab-pane">
            <p>Some content in menu 2.</p>
            {{--            <div class="py-3" id="rate">--}}
            {{--                <input type="radio" id="star5" name="rate" value="5" class="d-none" />--}}
            {{--                <label for="star5" title="text" class="fs-3">★</label>--}}
            {{--                <input type="radio" id="star4" name="rate" value="4" class="d-none" />--}}
            {{--                <label for="star4" title="text" class="fs-3">★</label>--}}
            {{--                <input type="radio" id="star3" name="rate" value="3" class="d-none" />--}}
            {{--                <label for="star3" title="text" class="fs-3">★</label>--}}
            {{--                <input type="radio" id="star2" name="rate" value="2" class="d-none" />--}}
            {{--                <label for="star2" title="text" class="fs-3">★</label>--}}
            {{--                <input type="radio" id="star1" name="rate" value="1" class="d-none" />--}}
            {{--                <label for="star1" title="text" class="fs-3">★</label>--}}
            {{--            </div>--}}

        </div>
    </div>
</div>
@endsection
