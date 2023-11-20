@extends('layouts.admin')

@section('script')
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">نمایش تگ </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.tags.index')}}">
            نمایش تگ ها
        </a>
    </div>
    <div class="m-5 d-flex justify-content-center">
        <form action="#" method="post" class="w-50">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="name">نام</label>
                <input type="text" id="name" value="{{$tag->name}}" class="form-control" disabled/>
            </div>

            <div class="mb-3">
                <label class="form-label" for="created_at">زمان ایجاد</label>
                <input type="text" id="created_at" value="{{$tag->created_at}}" class="form-control" disabled />
            </div>

        </form>
    </div>

@endsection
