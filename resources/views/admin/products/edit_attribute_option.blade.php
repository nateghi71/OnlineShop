@extends('layouts.admin')

@section('script')
    <script type="module">
        $('#attribute_normal').select2({
            placeholder: "ویژگی های موردنظر را انتخاب کنید",
        });
        $('#attribute_variation').select2({
            placeholder: "ویژگی های موردنظر را انتخاب کنید",
            maximumSelectionLength: 2
        });
    </script>
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">ویرایش محصول </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.products.index')}}">
            نمایش محصولات
        </a>
    </div>
    <div class="m-5 d-flex justify-content-center">
        <form action="{{route('admin.products.update' , ['product' => $product->id])}}" method="post" class="w-75">
            @csrf
            @method('put')

            <div class="col-md-12 my-4">
                <p class="text-primary">ویژگی ها :</p>
                <hr class="text-primary">
            </div>


            <div class="row">
                @foreach($product->attributeOptions()->where('is_variation' , 0)->get() as $attributeOption)
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="attribute_ids">{{$attributeOption->attr->name}}</label>
                        <input type="text" name="attribute_ids[{{$attributeOption->attr->id}}]" id="attribute_ids" value="{{$attributeOption->value}}" class="form-control" data-jdp/>
                    </div>
                @endforeach
            </div>

            <div class="col-md-12 my-4">
                <p class="text-primary">ویژگی های متغیر :</p>
                <hr class="text-primary">
            </div>

        @foreach($product->skus as $sku)
            <div class="row">
                <p class="bg-info">
                    @foreach($sku->attributeOptions as $attributeOption)
                        {{$attributeOption->attr->name}} : {{$attributeOption->value}} -
                    @endforeach
                </p>
                <div class="col-md-6 mb-3">
                    <label class="form-label">نام</label>
                    <input type="text" name="sku[code][]" value="{{$sku->code}}" class="form-control" data-jdp/>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">قیمت</label>
                    <input type="text" name="sku[price][]" value="{{$sku->price}}" class="form-control" data-jdp/>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">تعداد</label>
                    <input type="text" name="sku[quantity][]" value="{{$sku->quantity}}" class="form-control" data-jdp/>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">قیمت حراج</label>
                    <input type="text" name="sku[sale_price][]" value="{{$sku->sale_price}}" class="form-control" data-jdp/>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">تاریخ شروع حراج</label>
                    <input type="text" name="sku[date_on_sale_from][]" value="{{$sku->date_on_sale_from}}" class="form-control" data-jdp/>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">تاریخ پایان حراج</label>
                    <input type="text" name="sku[date_on_sale_to][]" value="{{$sku->date_on_sale_to}}" class="form-control" data-jdp/>
                </div>
            </div>
        @endforeach

        <button type="submit" class="w-100 btn btn-primary mb-4">ویرایش</button>

        </form>
    </div>

@endsection
