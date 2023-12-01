@extends('layouts.admin')

@section('script')
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">نمایش محصول </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.products.index')}}">
            نمایش محصولات
        </a>
    </div>
    <div class="m-5 d-flex justify-content-center">
        <form action="#" method="post" class="w-50">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="name">نام</label>
                    <input type="text" id="name" value="{{$product->name}}" class="form-control" disabled/>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="is_active">وضعیت</label>
                    <select class="form-select" id="is_active" name="is_active" disabled>
                        <option {{$product->is_active === 1 ? 'selected' : ''}}>فعال</option>
                        <option {{$product->is_active === 0 ? 'selected' : ''}}>غیرفعال</option>
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label" for="tagSelect">تگ</label>
                    <input type="text" id="name" value="{{implode(',' , $product->tags()->get()->pluck('name')->toArray())}}" class="form-control" disabled/>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="category_id">دسته بندی</label>
                    <select class="form-select" name="category_id" id="category_id" disabled>
                        @foreach($categories as $category)
                            <option
                                {{$category->id === $product->category_id ? 'selected' : ''}}>
                                {{$category->name}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="description">توضیحات</label>
                    <textarea name="description" id="description" class="form-control" disabled>{{$product->description}}</textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="delivery_amount">قیمت ارسال</label>
                    <input type="text" name="delivery_amount" id="delivery_amount" value="{{$product->delivery_amount}}" class="form-control" disabled/>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="delivery_amount_per_product">قیمت ارسال برای هر محصول اضافه</label>
                    <input type="text" name="delivery_amount_per_product" id="delivery_amount_per_product" value="{{$product->delivery_amount_per_product}}" class="form-control" disabled/>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="created_at">زمان ایجاد</label>
                <input type="text" id="created_at" value="{{$product->created_at}}" class="form-control" disabled />
            </div>

        </form>
    </div>

@endsection
