@extends('layouts.admin')

@section('script')
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">لیست دسته بندی ها </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.categories.create')}}">
            ایجاد دسته بندی
        </a>
    </div>
    <div>
        <table class="table table-bordered table-striped text-center">

            <thead>
            <tr>
                <th>id</th>
                <th>نام</th>
                <th>والد</th>
                <th>نامک</th>
                <th>ویرایش</th>
                <th>حذف</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($categories as $key => $category)
                <tr>
                    <th>
                        {{ $categories->firstItem() + $key }}
                    </th>
                    <th>
                        <a href="{{route('admin.categories.show' , ['category' => $category])}}" class="text-decoration-none">{{$category->name}}</a>
                    </th>
                    <th>
                        {{$category->parent_id}}
                    </th>

                    <th>
                        {{$category->slug}}
                    </th>
                    <th>
                        <a href="{{route('admin.categories.edit' , ['category' => $category])}}" class="btn btn-sm btn-outline-primary">ویرایش</a>
                    </th>
                    <th>
                        <form action="{{route('admin.categories.destroy' , ['category' => $category])}}" method="post">
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

    {{$categories->withQueryString()->links()}}

@endsection
