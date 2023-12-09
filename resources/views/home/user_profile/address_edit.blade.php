@extends('layouts.home')

@section('script')
@endsection

@section('content')
    <div class="col-sm-2">
        @include('sections.profile_sidebar')
    </div>
    <div class="col-sm-10">
        <div class="row p-3">
            <form action="{{route('home.profile.addresses.update' , ['user_address' => $userAddress])}}" method="post" class="row">
                @csrf
                @method('PUT')
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="title">عنوان</label>
                    <input type="text" name="title" id="title" value="{{$userAddress->title}}" class="form-control" />
                    @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="cellphone">تلفن</label>
                    <input type="text" name="cellphone" id="cellphone" value="{{$userAddress->cellphone}}" class="form-control" />
                    @error('cellphone')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="province">استان</label>
                    <input type="text" name="province" id="province" value="{{$userAddress->province_id}}" class="form-control" />
                    @error('provinces')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-4">
                    <label class="form-label" for="city">شهر</label>
                    <input type="text" name="city" id="city" value="{{$userAddress->city_id}}" class="form-control" />
                    @error('cities')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-4">
                    <label class="form-label" for="postal_code">کدپستی</label>
                    <input type="text" name="postal_code" id="postal_code" value="{{$userAddress->postal_code}}" class="form-control" />
                    @error('postal_code')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-9 mb-3">
                    <label class="form-label" for="address">ادرس</label>
                    <textarea name="address" id="address" class="form-control"> {{$userAddress->address}}</textarea>
                    @error('address')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mb-4">ویرایش ادرس</button>
            </form>
        </div>
    </div>
@endsection
