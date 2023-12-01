@extends('layouts.admin')

@section('script')
    <script type="module">
        $('#attribute_ids').select2({
            placeholder: "ویژگی های موردنظر را انتخاب کنید",
        });
    </script>
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">ویرایش دسته بندی </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.categories.index')}}">
            نمایش دسته بندی ها
        </a>
    </div>
    <div class="m-5 d-flex justify-content-center">
        <form action="{{route('admin.categories.update' , ['category' => $category->id])}}" method="post" class="w-50">
            @csrf
            @method('put')
            <div class="mb-3">
                <label class="form-label" for="name">نام</label>
                <input type="text" name="name" id="name" value="{{$category->name}}" class="form-control" />
                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="parent_id">والد</label>
                <select class="form-select" name="parent_id" id="parent_id">
                    <option value="0">بدون والد</option>
                    @foreach($categories as $category_temp)
                        <option value="{{$category_temp->id}}"
                            {{$category_temp->id === $category->parent_id ? 'selected' : ''}}>
                            {{$category_temp->name}}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="attribute_ids">ویژگی ها</label>
                <select class="form-select" name="attribute_ids[]" id="attribute_ids" multiple>
                    <option value="0">بدون والد</option>
                    @foreach($attributes as $attribute)
                        <option value="{{$attribute->id}}"
                            {{in_array($attribute->id,$category->attributes()->pluck('id')->toArray()) ? 'selected' : ''}}>
                            {{$attribute->name}}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="w-100 btn btn-primary mb-4">ویرایش</button>

        </form>
    </div>

@endsection
