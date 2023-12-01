@extends('layouts.admin')

@section('script')
    <script type="module">
        $('#tagSelect').select2({
            placeholder: "تگ های موردنظر را انتخاب کنید",
        });
        ClassicEditor.create( document.querySelector( '#description' ) ).catch( error => {
            console.error( error );
        } );
    </script>
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">ویرایش محصول </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.products.index')}}">
            نمایش محصولات
        </a>
    </div>
    @if(session()->has('errorDatabase'))
        <div class="alert alert-danger">{{ session('errorDatabase') }}</div>
    @endif
    <div class="m-5 d-flex justify-content-center">
        <form action="{{route('admin.products.update' , ['product' => $product->id])}}" method="post" class="w-50">
            @csrf
            @method('put')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="name">نام</label>
                    <input type="text" name="name" id="name" value="{{$product->name}}" class="form-control" data-jdp/>
                    @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="is_active">وضعیت</label>
                    <select class="form-select" id="is_active" name="is_active">
                        <option value="1" {{$product->is_active === 1 ? 'selected' : ''}}>فعال</option>
                        <option value="0" {{$product->is_active === 0 ? 'selected' : ''}}>غیرفعال</option>
                    </select>
                    @error('is_active')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="tagSelect">تگ</label>
                    <select id="tagSelect" name="tag_ids[]" class="form-select" multiple>
                        @foreach ($tags as $tag)
                            <option value="{{$tag->id}}"
                                {{in_array($tag->id,$product->tags()->pluck('id')->toArray()) ? 'selected' : ''}}>
                                {{$tag->name}}
                            </option>
                        @endforeach
                    </select>
                    @error('tag_ids')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="category_id">دسته بندی</label>
                    <select class="form-select" name="category_id" id="category_id">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}"
                                {{$category->id === $product->category_id ? 'selected' : ''}}>
                                {{$category->name}}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="description">توضیحات</label>
                    <textarea name="description" id="description" class="form-control" >{{$product->description}}</textarea>
                    @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="delivery_amount">قیمت ارسال</label>
                    <input type="text" name="delivery_amount" id="delivery_amount" value="{{$product->delivery_amount}}" class="form-control" />
                    @error('delivery_amount')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="delivery_amount_per_product">قیمت ارسال برای هر محصول اضافه</label>
                    <input type="text" name="delivery_amount_per_product" id="delivery_amount_per_product" value="{{$product->delivery_amount_per_product}}" class="form-control" />
                    @error('delivery_amount_per_product')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="w-100 btn btn-primary mb-4">ویرایش</button>

        </form>
    </div>

@endsection
