@extends('layouts.admin')

@section('script')
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">نمایش کوپن </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.coupons.index')}}">
            نمایش کوپن ها
        </a>
    </div>
    <div class="m-5 d-flex justify-content-center">
        <form action="#" method="post" class="w-50">
            @csrf
            <div class="mb-3">
                <label class="form-label">نام</label>
                <input type="text" value="{{$coupon->name}}" class="form-control" disabled/>
            </div>
            <div class="mb-3">
                <label class="form-label">کد</label>
                <input type="text" value="{{$coupon->code}}" class="form-control" disabled/>
            </div>
            <div class="mb-3">
                <label class="form-label">درصد</label>
                <input type="text" value="{{$coupon->percentage}}" class="form-control" disabled/>
            </div>
            <div class="mb-3">
                <label class="form-label">بیشترین مقدار تخفیف</label>
                <input type="text" value="{{$coupon->max_percentage_amount}}" class="form-control" disabled/>
            </div>
            <div class="mb-3">
                <label class="form-label">تاریخ انقضا</label>
                <input type="text" value="{{$coupon->expired_at}}" class="form-control" disabled/>
            </div>
            <div class="mb-3">
                <label class="form-label">توضیحات</label>
                <textarea class="form-control" disabled>{{$coupon->description}}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">زمان ایجاد</label>
                <input type="text" value="{{$coupon->created_at}}" class="form-control" disabled />
            </div>

        </form>
    </div>

@endsection
