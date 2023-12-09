@extends('layouts.home')

@section('script')
@endsection

@section('content')
    <div class="col-sm-2">
        @include('sections.profile_sidebar')
    </div>
    <div class="col-sm-10">
        <div class="row p-3">
            <div class="p-3 border-bottom">
                @foreach($userAddresses as $userAddress)
                    <div class="row p-3 mb-3 bg-body-tertiary rounded-5">
                        <p class="col-md-12">
                            <span>ادرس:</span>
                            <span>
                                {{$userAddress->province_id}} ,
                                {{$userAddress->city_id}} ,
                                {{$userAddress->address}}.
                            </span>
                        </p>
                        <p class="col-md-6">
                            <span>کد پستی:</span>
                            <span>
                                {{$userAddress->postal_code}}
                            </span>
                        </p>
                        <p class="col-md-6">
                            <span>تلفن:</span>
                            <span>
                                {{$userAddress->cellphone}}
                            </span>
                        </p>
                        <div class="d-flex justify-content-end">
                            <a href="{{route('home.profile.addresses.edit' , ['user_address' => $userAddress])}}"
                               class="text-decoration-none text-info me-3 mt-2">
                                ویرایش
                            </a>
                            <form action="{{route('home.profile.addresses.destroy' , ['user_address' => $userAddress])}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-decoration-none text-danger">حذف</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="p-3">
                <form action="{{route('home.profile.addresses.store')}}" method="post" class="row">
                    @csrf
                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="title">عنوان</label>
                        <input type="text" name="title" id="title" class="form-control" />
                        @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="cellphone">تلفن</label>
                        <input type="text" name="cellphone" id="cellphone" class="form-control" />
                        @error('cellphone')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="province">استان</label>
                        <input type="text" name="province" id="province" class="form-control" />
                        @error('provinces')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label class="form-label" for="city">شهر</label>
                        <input type="text" name="city" id="city" class="form-control" />
                        @error('cities')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label class="form-label" for="postal_code">کدپستی</label>
                        <input type="text" name="postal_code" id="postal_code" class="form-control" />
                        @error('postal_code')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-9 mb-3">
                        <label class="form-label" for="address">ادرس</label>
                        <textarea name="address" id="address" class="form-control" ></textarea>
                        @error('address')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mb-4">ثبت ادرس</button>
                </form>
            </div>
        </div>
    </div>
@endsection
