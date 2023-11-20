@extends('layouts.admin')

@section('script')
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">نمایش دسته بندی </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.categories.index')}}">
            نمایش دسته بندی ها
        </a>
    </div>
    <div class="m-5 d-flex justify-content-center">
        <form action="#" method="post" class="w-50">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="name">نام</label>
                <input type="text" id="name" value="{{$category->name}}" class="form-control" disabled/>
            </div>
            <div class="mb-3">
                <label class="form-label" for="slug">نامک</label>
                <input type="text" id="slug" value="{{$category->slug}}" class="form-control" disabled/>
            </div>
            <div class="mb-3">
                <label class="form-label" for="parent_id">والد</label>
                <input type="text" id="parent_id" value="{{$category->parent_id}}" class="form-control" disabled/>
            </div>

            <div class="mb-3">
                <label class="form-label" for="created_at">زمان ایجاد</label>
                <input type="text" id="created_at" value="{{$category->created_at}}" class="form-control" disabled />
            </div>

        </form>
    </div>

@endsection
