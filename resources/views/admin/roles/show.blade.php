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
        <h5 class="font-weight-bold">نمایش نقش </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.roles.index')}}">
            نمایش نقش ها
        </a>
    </div>
    <div class="m-5 d-flex justify-content-center">
        <form action="{{route('admin.roles.show' , ['role' => $role->id])}}" method="post" class="w-50">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="name">نام</label>
                <input type="text" name="name" id="name" value="{{$role->name}}" class="form-control" disabled/>
            </div>

            <div class="mb-3">
                <label class="form-label" for="permissions">مجوز دسترسی</label>
                <select class="form-select select2" name="permissions[]" id="permissions" multiple="multiple" disabled>
                    @foreach($permissions as $permission)
                        <option value="{{$permission->id}}"
                            {{in_array($permission->id, $role->permissions()->pluck('id')->toArray()) ? 'selected' : ''}}>
                            {{$permission->name}}
                        </option>
                    @endforeach
                </select>
            </div>

        </form>
    </div>

@endsection
