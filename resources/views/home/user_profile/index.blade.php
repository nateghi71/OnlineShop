@extends('layouts.home')

@section('script')
@endsection

@section('content')
    <div class="col-sm-2">
        @include('sections.profile_sidebar')
    </div>
    <div class="col-sm-10">
        <div class="row p-3">
            <div class="m-5 d-flex justify-content-center">
                <form action="{{route('home.profile.update' , ['user' => auth()->user()->id])}}" method="post" class="w-50">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label class="form-label" for="name">نام</label>
                        <input type="text" name="name" id="name" value="{{auth()->user()->name}}" class="form-control @error('name') is-invalid @enderror" />
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="email">ایمیل</label>
                        <input type="email" name="email" id="email" value="{{auth()->user()->email}}" class="form-control @error('email') is-invalid @enderror" />
                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password_old">گذرواژه پیشین</label>
                        <input type="password_old" name="password_old" value="" id="password" class="form-control @error('password') is-invalid @enderror" />
                        @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password_new">گذرواژه جدید</label>
                        <input type="password" name="password_new" value="" id="password_new" class="form-control @error('password') is-invalid @enderror" />
                        @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password_new_confirmation">گذرواژه جدید</label>
                        <input type="password" name="password_new_confirmation" value="" id="password_new_confirmation" class="form-control @error('password') is-invalid @enderror" />
                        @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="w-100 btn btn-primary mb-4">ذخیره تغییرات</button>

                </form>
            </div>

        </div>
    </div>
@endsection
