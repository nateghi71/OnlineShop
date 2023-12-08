@extends('layouts.admin')

@section('script')
@endsection

@section('content')
    <div class="m-4">
        <h5 class="font-weight-bold">لیست کامنت ها </h5>
    </div>
    <div>
        <table class="table table-bordered table-striped text-center">

            <thead>
            <tr>
                <th>id</th>
                <th>متن</th>
                <th>کاربر</th>
                <th>محصول</th>
                <th>تایید</th>
                <th>حذف</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($comments as $key => $comment)
                <tr>
                    <th>
                        {{ $comments->firstItem() + $key }}
                    </th>

                    <th>
                        <a href="{{route('admin.comments.show' , ['comment' => $comment])}}" class="text-decoration-none">
                            {{$comment->text}}
                        </a>
                    </th>
                    <th>
                        <a href="{{route('admin.users.show' , ['user' => $comment->user])}}" class="text-decoration-none">
                            {{$comment->user->name}}
                        </a>
                    </th>
                    <th>
                        <a href="{{route('admin.products.show' , ['product' => $comment->product])}}" class="text-decoration-none">
                            {{$comment->product->name}}
                        </a>
                    </th>
                    <th>
                        <a href="{{route('admin.comments.approve' , ['comment' => $comment])}}" class="btn btn-sm btn-outline-primary">
                            {{$comment->approved}}
                        </a>
                    </th>
                    <th>
                        <form action="{{route('admin.comments.destroy' , ['comment' => $comment])}}" method="post">
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

    {{$comments->withQueryString()->links()}}

@endsection
