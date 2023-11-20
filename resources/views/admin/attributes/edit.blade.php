@extends('layouts.admin')

@section('script')
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">ویرایش مجوز </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.attributes.index')}}">
            نمایش مجوز ها
        </a>
    </div>
    <div class="m-5 d-flex justify-content-center">
        <form action="{{route('admin.attributes.update' , ['attribute' => $attribute->id])}}" method="post" class="w-50">
            @csrf
            @method('put')

            <div class="mb-3">
                <label class="form-label" for="name">نام</label>
                <input type="text" name="name" id="name" value="{{$attribute->name}}" class="form-control" />
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="w-100 btn btn-primary mb-4">ویرایش</button>

        </form>
    </div>

@endsection
