@extends('layouts.home')

@section('scripts')
@endsection

@section('content')
    <div class="d-flex justify-content-center pt-5">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{route('register.handle')}}" method="post" class="w-25 bg-light p-4 rounded-4">
           @csrf
            <div class="mb-3">
                <label class="form-label" for="name">نام</label>
                <input type="name" name="name" id="name" class="form-control" />
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email input -->
            <div class="mb-3">
                <label class="form-label" for="email">ایمیل</label>
                <input type="email" name="email" id="email" class="form-control" />
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password input -->
            <div class="mb-4">
                <label class="form-label" for="password">کلمه عبور</label>
                <input type="password" name="password" id="password" class="form-control" />
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password input -->
            <div class="mb-4">
                <label class="form-label" for="password_confirmation">تکرار کلمه عبور</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" />
            </div>

            <!-- Submit button -->
            <button type="submit" class="w-100 btn btn-primary mb-4">ثبت نام</button>

            <div class="text-center">
                <!-- Register buttons -->
                <p>عضو هستم؟ <a href="{{route('login')}}" class="text-decoration-none">ورود</a></p>
            </div>

        </form>
    </div>
@endsection
