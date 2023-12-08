@extends('layouts.admin')

@section('script')
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">لیست کاربران </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.users.create')}}">
            ایجاد کاربر
        </a>
    </div>
    <div>
        <table class="table table-bordered table-striped text-center">

            <thead>
            <tr>
                <th>#</th>
                <th>نام</th>
                <th>ایمیل</th>
                <th>ویرایش</th>
                <th>حذف</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $key => $user)
                <tr>
                    <th>
                        {{ $users->firstItem() + $key }}
                    </th>

                    <th>
                        <a href="{{ route('admin.users.show', ['user' =>$user->id]) }}" class="text-decoration-none">{{$user->name}}</a>
                    </th>
                    <th>
                        {{$user->email}}
                    </th>
                    <th>
                        <a href="{{ route('admin.users.edit', ['user' =>$user->id]) }}" class="btn btn-sm btn-outline-primary">ویرایش</a>
                    </th>
                    <th>
                        <form action="{{route('admin.users.destroy', ['user' =>$user->id])}}" method="post">
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

    {{$users->withQueryString()->links()}}

@endsection
