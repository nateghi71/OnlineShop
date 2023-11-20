@extends('layouts.admin')

@section('script')
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">لیست تگ ها </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.tags.create')}}">
            ایجاد تگ
        </a>
    </div>
    <div>
        <table class="table table-bordered table-striped text-center">

            <thead>
            <tr>
                <th>id</th>
                <th>نام</th>
                <th>نامک</th>
                <th>ویرایش</th>
                <th>حذف</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($tags as $key => $tag)
                <tr>
                    <th>
                        {{ $tags->firstItem() + $key }}
                    </th>

                    <th>
                        <a href="{{route('admin.tags.show' , ['tag' => $tag])}}" class="text-decoration-none">{{$tag->name}}</a>
                    </th>
                    <th>
                        {{$tag->slug}}
                    </th>
                    <th>
                        <a href="{{route('admin.tags.edit' , ['tag' => $tag])}}" class="btn btn-sm btn-outline-primary">ویرایش</a>
                    </th>
                    <th>
                        <form action="{{route('admin.tags.destroy' , ['tag' => $tag])}}" method="post">
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

    {{$tags->withQueryString()->links()}}

@endsection
