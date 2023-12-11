@extends('layouts.admin')

@section('script')
@endsection

@section('content')
    <div class="m-4">
        <h5 class="font-weight-bold">لیست سفارشات </h5>
    </div>
    <div>
        <table class="table table-bordered table-striped text-center">

            <thead>
            <tr>
                <th>id</th>
                <th>شماره سفارش</th>
                <th>کاربر</th>
                <th>مبلغ پرداختی</th>
                <th>وضعیت سفارش</th>
                <th>حذف</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $key => $order)
                <tr>
                    <th>
                        {{ $orders->firstItem() + $key }}
                    </th>

                    <th>
                        <a href="{{route('admin.orders.show' , ['order' => $order])}}" class="text-decoration-none">
                            order {{$order->id}}
                        </a>
                    </th>
                    <th>
                        <a href="{{route('admin.users.show' , ['user' => $order->user])}}" class="text-decoration-none">
                            {{$order->user->name}}
                        </a>
                    </th>
                    <th>
                        {{$order->paying_amount}}
                    </th>
                    <th>
                        {{$order->payment_status}}
                    </th>
                    <th>
                        <form action="{{route('admin.orders.destroy' , ['order' => $order])}}" method="post">
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

    {{$orders->withQueryString()->links()}}

@endsection
