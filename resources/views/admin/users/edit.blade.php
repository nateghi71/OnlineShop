@extends('layouts.admin')

@section('script')
    <script type="module">
        $(function() {
            $('.select2').select2();
        });
    </script>
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">ویرایش کاربران </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.users.index')}}">
            نمایش کاربران
        </a>
    </div>
    <div class="m-5 d-flex justify-content-center">
        <form action="{{route('admin.users.update' , ['user' => $user->id])}}" method="post" class="w-50">
            @csrf
            @method('put')

            <div class="mb-3">
                <label class="form-label" for="name">نام</label>
                <input type="text" name="name" id="name" value="{{$user->name}}" class="form-control @error('name') is-invalid @enderror" />
                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="email">ایمیل</label>
                <input type="email" name="email" id="email" value="{{$user->email}}" class="form-control @error('email') is-invalid @enderror" />
                @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="password">کلمه عبور</label>
                <input type="password" name="password" value="{{$user->password}}" id="password" class="form-control @error('password') is-invalid @enderror" />
                @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="role">نقش</label>
                <select class="form-select select2 @error('role') is-invalid @enderror" name="role" id="role">
                    @foreach($roles as $role)
                        <option value="{{$role->id}}"
                        {{$role->id === $user->role->id ? 'selected' : ''}}>
                            {{$role->name}}
                        </option>
                    @endforeach
                </select>
                @error('role')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="w-100 btn btn-primary mb-4">ویرایش</button>

        </form>
    </div>

@endsection
