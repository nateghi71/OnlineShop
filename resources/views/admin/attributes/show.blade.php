@extends('layouts.admin')

@section('script')
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">نمایش مجوز </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.attributes.index')}}">
            نمایش مجوز ها
        </a>
    </div>
    <div class="m-5 d-flex justify-content-center">
        <form action="{{route('admin.attributes.show' , ['attribute' => $attribute->id])}}" method="post" class="w-50">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="name">نام</label>
                <input type="text" id="name" value="{{$attribute->name}}" class="form-control" disabled/>
            </div>

            <div class="mb-3">
                <label class="form-label" for="created_at">زمان ایجاد</label>
                <input type="text" id="created_at" value="{{$attribute->created_at}}" class="form-control" disabled />
            </div>

        </form>
    </div>

@endsection
