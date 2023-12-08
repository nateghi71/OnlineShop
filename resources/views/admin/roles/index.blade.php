@extends('layouts.admin')

@section('script')
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">لیست نقش ها </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.roles.create')}}">
            ایجاد نقش
        </a>
    </div>
    <div>
        <table class="table table-bordered table-striped text-center">

            <thead>
            <tr>
                <th>#</th>
                <th>نام</th>
                <th>ویرایش</th>
                <th>حذف</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($roles as $key => $role)
                <tr>
                    <th>
                        {{ $roles->firstItem() + $key }}
                    </th>

                    <th>
                        <a href="{{ route('admin.roles.show', ['role' =>$role->id]) }}" class="text-decoration-none">{{$role->name}}</a>
                    </th>
                    <th>
                        <a href="{{ route('admin.roles.edit', ['role' =>$role->id]) }}" class="btn btn-sm btn-outline-primary">ویرایش</a>
                    </th>
                    <th>
                        <form action="{{route('admin.roles.destroy', ['role' =>$role->id])}}" method="post">
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

    {{$roles->withQueryString()->links()}}

@endsection
