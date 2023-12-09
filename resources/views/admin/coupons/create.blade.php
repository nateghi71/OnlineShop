@extends('layouts.admin')

@section('script')
    <script type="module">
    </script>
@endsection

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h5 class="font-weight-bold">ایجاد کوپن </h5>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.coupons.index')}}">
            نمایش کوپن ها
        </a>
    </div>
    <div class="m-5 d-flex justify-content-center">
        <form action="{{route('admin.coupons.store')}}" method="post" class="w-50">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="name">نام</label>
                <input type="text" name="name" id="name" class="form-control" />
                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="code">کد</label>
                <input type="text" name="code" id="code" class="form-control" />
                @error('code')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="percentage">درصد</label>
                <input type="text" name="percentage" id="percentage" class="form-control" />
                @error('percentage')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="max_percentage_amount">بیشترین مقدار تخفیف</label>
                <input type="text" name="max_percentage_amount" id="max_percentage_amount" class="form-control" />
                @error('max_percentage_amount')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="expired_at">تاریخ انقضا</label>
                <input type="text" name="expired_at" id="expired_at" class="form-control" />
                @error('expired_at')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="description">توضیحات</label>
                <textarea name="description" id="description" class="form-control" ></textarea>
                @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="w-100 btn btn-primary mb-4">ارسال</button>

        </form>
    </div>


@endsection
