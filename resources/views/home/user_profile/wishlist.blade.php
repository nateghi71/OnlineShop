@extends('layouts.home')

@section('script')
@endsection

@section('content')
    <div class="col-sm-2">
        @include('sections.profile_sidebar')
    </div>
    <div class="col-sm-10">
        <div class="row p-3">
            <table class="table table-bordered table-striped text-center">
                <thead>
                <tr>
                    <th>id</th>
                    <th>نام</th>
                    <th>عکس</th>
                    <th>حذف</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($products as $key => $product)
                    <tr>
                        <th>
                            {{ $products->firstItem() + $key }}
                        </th>

                        <th>
                            <a href="{{route('home.product.show' , ['product'=>$product->slug])}}" class="text-decoration-none">{{$product->name}}</a>
                        </th>
                        <th>
                            <img
                                 src="{{url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $product->images()->where('is_primary' , 1)->first()->image)}}"
                                 alt="{{$product->name}}" width="100" height="100">
                        </th>
                        <th>
                            <a href="{{route('home.wishlist.destroy' , ['product'=>$product->id])}}" class="text-decoration-none text-danger">حذف</a>
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{$products->withQueryString()->links()}}
    </div>
@endsection
