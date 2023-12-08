@extends('layouts.admin')

@section('script')
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">لیست مجوز ها </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.permissions.create')}}">
            ایجاد مجوز
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
            @foreach ($permissions as $key => $permission)
                <tr>
                    <th>
                        {{ $permissions->firstItem() + $key }}
                    </th>

                    <th>
                        <a href="{{ route('admin.permissions.show', ['permission' =>$permission->id]) }}" class="text-decoration-none">{{$permission->name}}</a>
                    </th>
                    <th>
                        <a href="{{ route('admin.permissions.edit', ['permission' =>$permission->id]) }}" class="btn btn-sm btn-outline-primary">ویرایش</a>
                    </th>
                    <th>
                        <form action="{{route('admin.permissions.destroy', ['permission' =>$permission->id])}}" method="post">
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

    {{$permissions->withQueryString()->links()}}

@endsection
