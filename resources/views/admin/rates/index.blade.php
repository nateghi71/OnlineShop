@extends('layouts.admin')

@section('script')
@endsection

@section('content')
    <div class="m-4">
        <h5 class="font-weight-bold">لیست امتیاز ها </h5>
    </div>
    <div>
        <table class="table table-bordered table-striped text-center">

            <thead>
            <tr>
                <th>id</th>
                <th>امتیاز</th>
                <th>کاربر</th>
                <th>محصول</th>
                <th>حذف</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($rates as $key => $rate)
                <tr>
                    <th>
                        {{ $rates->firstItem() + $key }}
                    </th>

                    <th>
                        {{$rate->rate}}
                    </th>
                    <th>
                        <a href="{{route('admin.users.show' , ['user' => $rate->user])}}" class="text-decoration-none">
                            {{$rate->user->name}}
                        </a>
                    </th>
                    <th>
                        <a href="{{route('admin.products.show' , ['product' => $rate->product])}}" class="text-decoration-none">
                            {{$rate->product->name}}
                        </a>
                    </th>
                    <th>
                        <form action="{{route('admin.rates.destroy' , ['product_rate' => $rate])}}" method="post">
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

    {{$rates->withQueryString()->links()}}

@endsection
