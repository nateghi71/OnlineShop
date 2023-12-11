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
                <th>شماره تراکنش</th>
                <th>کاربر</th>
                <th>شماره پیگیری</th>
                <th>وضعیت تراکنش</th>
                <th>حذف</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($transactions as $key => $transaction)
                <tr>
                    <th>
                        {{ $transactions->firstItem() + $key }}
                    </th>

                    <th>
                        <a href="{{route('admin.transactions.show' , ['transaction' => $transaction])}}" class="text-decoration-none">
                            transaction {{$transaction->id}}
                        </a>
                    </th>
                    <th>
                        <a href="{{route('admin.users.show' , ['user' => $transaction->user])}}" class="text-decoration-none">
                            {{$transaction->user->name}}
                        </a>
                    </th>
                    <th>
                        {{$transaction->ref_id}}
                    </th>
                    <th>
                        {{$transaction->status}}
                    </th>
                    <th>
                        <form action="{{route('admin.transactions.destroy' , ['transaction' => $transaction])}}" method="post">
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

    {{$transactions->withQueryString()->links()}}

@endsection
