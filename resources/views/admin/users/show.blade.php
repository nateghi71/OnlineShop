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
        <h5 class="font-weight-bold">نمایش کاربر </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.users.index')}}">
            نمایش کاربران
        </a>
    </div>
    <div class="m-5 d-flex justify-content-center">
        <form action="{{route('admin.users.show' , ['user' => $user->id])}}" method="post" class="w-50">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="name">نام</label>
                <input type="text" name="name" id="name" value="{{$user->name}}" class="form-control" disabled/>
            </div>

            <div class="mb-3">
                <label class="form-label" for="email">ایمیل</label>
                <input type="email" name="email" id="email" value="{{$user->email}}" class="form-control" disabled />
            </div>

            <div class="mb-3">
                <label class="form-label" for="role">نقش</label>
                <select class="form-select select2" name="role" id="role" disabled>
                    @foreach($roles as $role)
                        <option value="{{$role->id}}"
                            {{$role->id === $user->role->id ? 'selected' : ''}}>
                            {{$role->name}}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

@endsection
