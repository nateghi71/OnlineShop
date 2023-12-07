@extends('layouts.home')

@section('script')
@endsection

@section('content')
    @foreach($categories->Where('parent_id' ,'!==', 0) as $category)
    <div class="row">
        <div class="col-md-12 my-3 mx-5">
            <h4 class="text-primary">{{$category->name}}</h4>
            <hr class="text-primary">
        </div>
        @foreach($category->products as $product)
        <div class="col-md-3">
            <div class="card mb-3">
                <img class="card-img-top"
                     src="{{url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $product->images()->where('is_primary' , 1)->first()->image)}}"
                     alt="{{$product->name}}">
                <div class="card-body text-center">
                    <a href="{{route('home.product.show' , ['product'=>$product->slug])}}" class="card-title text-decoration-none">
                        <h5 class="text-start text-primary mb-3">{{$product->name}}</h5>
                    </a>
                    <p class="card-text text-danger d-flex justify-content-between">قیمت:<span>{{$product->delivery_amount}}</span></p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach
@endsection