@extends('layouts.admin')

@section('script')
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">نمایش کامنت </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.comments.index')}}">
            نمایش کامنت ها
        </a>
    </div>
    <div class="m-5 d-flex justify-content-center">
        <form action="#" method="post" class="w-50">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="name">نام</label>
                <textarea class="form-control"  disabled>{{$comment->text}}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label" for="created_at">زمان ایجاد</label>
                <input type="text" id="created_at" value="{{$comment->created_at}}" class="form-control" disabled />
            </div>

        </form>
    </div>

@endsection
