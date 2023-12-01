@extends('layouts.admin')

@section('script')
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">لیست محصول ها </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.products.create')}}">
            ایجاد محصول
        </a>
    </div>
    <div>
        <table class="table table-bordered table-striped text-center">

            <thead>
            <tr>
                <th>id</th>
                <th>نام</th>
                <th>دسته بندی</th>
                <th>وضعیت</th>
                <th>ویرایش</th>
                <th>ویرایش ویژگی ها</th>
                <th>ویرایش عکس ها</th>
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
                        <a href="{{route('admin.products.show' , ['product' => $product])}}" class="text-decoration-none">{{$product->name}}</a>
                    </th>
                    <th>
                        {{$product->category->name}}
                    </th>
                    <th>
                        {{$product->is_active ? 'فعال' : 'غیرفعال'}}
                    </th>
                    <th>
                        <a href="{{route('admin.products.edit' , ['product' => $product])}}" class="btn btn-sm btn-outline-primary">ویرایش</a>
                    </th>
                    <th>
                        <a href="{{route('admin.products.edit_attributes' , ['product' => $product])}}" class="btn btn-sm btn-outline-primary">ویرایش ویژگی ها</a>
                    </th>
                    <th>
                        <a href="{{route('admin.products.edit_images' , ['product' => $product])}}" class="btn btn-sm btn-outline-primary"> ویرایش عکس ها</a>
                    </th>
                    <th>
                        <form action="{{route('admin.products.destroy' , ['product' => $product])}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline-danger">حذف</button>
                        </form>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{$products->withQueryString()->links()}}

@endsection
