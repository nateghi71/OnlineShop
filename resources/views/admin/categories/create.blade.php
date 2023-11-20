@extends('layouts.admin')

@section('script')
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">ایجاد دسته بندی </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.categories.index')}}">
            نمایش دسته بندی ها
        </a>
    </div>
    <div class="m-5 d-flex justify-content-center">
        <form action="{{route('admin.categories.store')}}" method="post" class="w-50">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="name">نام</label>
                <input type="text" name="name" id="name" class="form-control" />
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="parent_id">والد</label>
                <select class="form-select" name="parent_id" id="parent_id">
                    <option value="0" selected>بدون والد</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                @error('parent_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="w-100 btn btn-primary mb-4">ارسال</button>

        </form>
    </div>


@endsection
