@extends('layouts.admin')

@section('script')
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">لیست کوپن ها </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.coupons.create')}}">
            ایجاد کوپن
        </a>
    </div>
    <div>
        <table class="table table-bordered table-striped text-center">

            <thead>
            <tr>
                <th>id</th>
                <th>نام</th>
                <th>کد</th>
                <th>درصد</th>
                <th>تاریخ انقضا</th>
                <th>ویرایش</th>
                <th>حذف</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($coupons as $key => $coupon)
                <tr>
                    <th>
                        {{ $coupons->firstItem() + $key }}
                    </th>
                    <th>
                        <a href="{{route('admin.coupons.show' , ['coupon' => $coupon])}}" class="text-decoration-none">{{$coupon->name}}</a>
                    </th>
                    <th>
                        {{$coupon->code}}
                    </th>

                    <th>
                        {{$coupon->percentage}}
                    </th>
                    <th>
                        {{$coupon->expired_at}}
                    </th>
                    <th>
                        <a href="{{route('admin.coupons.edit' , ['coupon' => $coupon])}}" class="btn btn-sm btn-outline-primary">ویرایش</a>
                    </th>
                    <th>
                        <form action="{{route('admin.coupons.destroy' , ['coupon' => $coupon])}}" method="post">
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

    {{$coupons->withQueryString()->links()}}

@endsection
