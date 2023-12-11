@extends('layouts.admin')

@section('script')
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">نمایش تراکنش </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.transactions.index')}}">
            نمایش تراکنش ها
        </a>
    </div>
    <div class="m-5 d-flex justify-content-center">
        <form action="#" method="post" class="w-50">
            @csrf
            <div class="mb-3">
                <label class="form-label">کاربر</label>
                <input type="text" value="{{$transaction->user->name}}" class="form-control" disabled />
            </div>
            <div class="mb-3">
                <label class="form-label">سفارش</label>
                <input type="text" value="order {{$transaction->order_id}}" class="form-control" disabled />
            </div>
            <div class="mb-3">
                <label class="form-label">مبلغ</label>
                <input type="text" value="{{$transaction->amount}}" class="form-control" disabled />
            </div>
            <div class="mb-3">
                <label class="form-label">شماره پیگیری</label>
                <input type="text" value="{{$transaction->ref_id}}" class="form-control" disabled />
            </div>
            <div class="mb-3">
                <label class="form-label">توکن پرداخت</label>
                <input type="text" value="{{$transaction->token}}" class="form-control" disabled />
            </div>
            <div class="mb-3">
                <label class="form-label">درگاه پرداخت</label>
                <input type="text" value="{{$transaction->gateway_name}}" class="form-control" disabled />
            </div>
            <div class="mb-3">
                <label class="form-label">وضعیت تراکنش</label>
                <input type="text" value="{{$transaction->status}}" class="form-control" disabled />
            </div>

            <div class="mb-3">
                <label class="form-label" for="name">توضیحات</label>
                <textarea class="form-control"  disabled>{{$transaction->description}}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label" for="created_at">زمان ایجاد</label>
                <input type="text" id="created_at" value="{{$transaction->created_at}}" class="form-control" disabled />
            </div>

        </form>
    </div>

@endsection
