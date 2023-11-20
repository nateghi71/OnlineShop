@extends('layouts.admin')

@section('script')
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">لیست ویژگی ها </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.attributes.create')}}">
            ایجاد ویژگی
        </a>
    </div>
    <div>
        <table class="table table-bordered table-striped text-center">

            <thead>
            <tr>
                <th>id</th>
                <th>نام</th>
                <th>ویرایش</th>
                <th>حذف</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($attributes as $key => $attribute)
                <tr>
                    <th>
                        {{ $attributes->firstItem() + $key }}
                    </th>

                    <th>
                        <a href="{{route('admin.attributes.show' , ['attribute' => $attribute])}}" class="text-decoration-none">{{$attribute->name}}</a>
                    </th>
                    <th>
                        <a href="{{route('admin.attributes.edit' , ['attribute' => $attribute])}}" class="btn btn-sm btn-outline-primary">ویرایش</a>
                    </th>
                    <th>
                        <form action="{{route('admin.attributes.destroy' , ['attribute' => $attribute])}}" method="post">
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

    {{$attributes->withQueryString()->links()}}

@endsection
