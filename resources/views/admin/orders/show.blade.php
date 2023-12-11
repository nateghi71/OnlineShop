@extends('layouts.admin')

@section('script')
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">نمایش سفارش </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.orders.index')}}">
            نمایش سفارشات
        </a>
    </div>
    <div class="m-5 d-flex justify-content-center">
        <div class="w-50">
            <div class="mb-3">
                <label class="form-label">کاربر</label>
                <input type="text" value="{{$order->user->name}}" class="form-control" disabled />
            </div>
            <div class="mb-3">
                <label class="form-label">کوپن</label>
                <input type="text" value="{{$order->coupon ? $order->coupon->name : ''}}" class="form-control" disabled />
            </div>
            <div class="mb-3">
                <label class="form-label">مجموع قیمت ها</label>
                <input type="text" value="{{$order->total_amount}}" class="form-control" disabled />
            </div>
            <div class="mb-3">
                <label class="form-label">مجموع هزینه حمل و نقل</label>
                <input type="text" value="{{$order->delivery_amount}}" class="form-control" disabled />
            </div>
            <div class="mb-3">
                <label class="form-label">مبلغ کوپن</label>
                <input type="text" value="{{$order->coupon_amount}}" class="form-control" disabled />
            </div>
            <div class="mb-3">
                <label class="form-label">مبلغ پرداختی</label>
                <input type="text" value="{{$order->paying_amount}}" class="form-control" disabled />
            </div>
            <div class="mb-3">
                <label class="form-label">نوع پرداخت</label>
                <input type="text" value="{{$order->payment_type}}" class="form-control" disabled />
            </div>

            <div class="mb-3">
                <label class="form-label">توضیحات</label>
                <textarea class="form-control"  disabled>{{$order->description}}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">زمان ایجاد</label>
                <input type="text" value="{{$order->created_at}}" class="form-control" disabled />
            </div>

        </div>
    </div>
    @foreach($order->orderItems as $orderItem)
        <hr>
        <div class="m-5 row">
            <div class="col-md-3 mb-3">
                <label class="form-label">محصول</label>
                <input type="text" value="{{$orderItem->product->name}}" class="form-control" disabled />
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">sku</label>
                <input type="text" value="{{$orderItem->sku->code}}" class="form-control" disabled />
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">فی</label>
                <input type="text" value="{{$orderItem->price}}" class="form-control" disabled />
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">تعداد</label>
                <input type="text" value="{{$orderItem->quantity}}" class="form-control" disabled />
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">قیمت</label>
                <input type="text" value="{{$orderItem->subtotal}}" class="form-control" disabled />
            </div>
        </div>
    @endforeach
@endsection
