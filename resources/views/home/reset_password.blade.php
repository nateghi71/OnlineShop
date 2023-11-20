@extends('layouts.home')

@section('scripts')
@endsection

@section('content')
    <div class="pt-5">
        @if(session()->has('email'))
            <div class="alert alert-danger">
                {{ session('email') }}
            </div>
        @endif

        <p class="fs-4 text-center">اطلاعات خواسته شده را وارد کنید.</p>
        <div class="mt-5 d-flex justify-content-center">
            <form action="{{route('password.update')}}" method="post" class="w-25">
                @csrf
                <diV class="mb-3">
                    <label for="email" class="form-label">ایمیل</label>
                    <input type="email" name="email" id="email" class="form-control">
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </diV>
                <diV class="mb-3">
                    <label for="password " class="form-label">پسورد</label>
                    <input type="password" name="password" id="password" class="form-control">
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </diV>
                <diV class="mb-4">
                    <label for="password_confirmation" class="form-label">تایید پسورد</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </diV>

                <input type="hidden" name="token" value="{{$token}}">
                <button type="submit" class="w-100 btn btn-primary">ارسال</button>
            </form>
        </div>
    </div>
@endsection
