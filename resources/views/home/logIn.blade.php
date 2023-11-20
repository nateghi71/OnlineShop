@extends('layouts.home')

@section('scripts')
@endsection

@section('content')
    <div class="d-flex justify-content-center pt-5">
        <form action="{{route('login.handle')}}" method="post" class="w-25 bg-light p-4 rounded-4">
            @csrf
            @if(session()->has('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <!-- Email input -->
            <div class="mb-3">
                <label class="form-label" for="email">ایمیل</label>
                <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}" />
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password input -->
            <div class="mb-3">
                <label class="form-label" for="password">کلمه عبور</label>
                <input type="password" name="password" id="password" class="form-control" value="{{old('password')}}" />
                @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Checkbox -->
            <div class="form-check mb-3">
                <input class="form-check-input" name="remember_me" type="checkbox" value="" id="form2Example31"/>
                <label class="form-check-label" for="form2Example31"> مرا بخاطر بسپار </label>
            </div>

            <!-- Submit button -->
            <button type="submit" class="w-100 btn btn-primary mb-3">ورود</button>

            <!-- 2 column grid layout for inline styling -->
            <div class="row mb-3">
                <div class="col d-flex justify-content-center">
                    <!-- Register buttons -->
                    <p>عضو نیستم؟ <a href="{{route('register')}}" class="text-decoration-none">ثبت نام</a></p>
                </div>

                <div class="col d-flex justify-content-center">
                    <!-- Simple link -->
                    <a href="{{route('password.request')}}" class="text-decoration-none">فراموشی پسورد؟</a>
                </div>
            </div>

        </form>
    </div>

@endsection
