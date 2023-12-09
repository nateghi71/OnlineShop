@extends('layouts.home')

@section('script')
@endsection

@section('content')
    <div class="col-md-9">
        <div class="ps-4 p-3">
            <h4 class="border-bottom pb-3">ادرس تحویل سفارش:</h4>
        </div>
        <div class="row p-3">
            <div class="col-md-3 mb-3 ">
                <label class="form-label fs-5" for="select_address">انتخاب ادرس تحویل سفارش:</label>
            </div>
            <div class="col-md-3 mb-3 ">
                <select name="select_address" id="select_address" class="form-control">
                    @foreach(auth()->user()->userAddresses as $userAddress)
                        <option value="{{$userAddress->id}}">{{$userAddress->title}}</option>
                    @endforeach
                </select>
                @error('select_address')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-3 mb-3 text-center">
                <button type="button" class="btn btn-info" data-bs-toggle="collapse" data-bs-target="#newAddress"
                        aria-expanded="false" aria-controls="newAddress">
                    ادرس جدید
                </button>
            </div>
        </div>
        <div class="collapse" id="newAddress">
            <hr class="m-4">
            <div class="p-3">
                <form action="{{route('home.profile.addresses.store')}}" method="post" class="row">
                    @csrf
                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="title">عنوان</label>
                        <input type="text" name="title" id="title" class="form-control"/>
                        @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="cellphone">تلفن</label>
                        <input type="text" name="cellphone" id="cellphone" class="form-control"/>
                        @error('cellphone')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="province">استان</label>
                        <input type="text" name="province" id="province" class="form-control"/>
                        @error('provinces')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label class="form-label" for="city">شهر</label>
                        <input type="text" name="city" id="city" class="form-control"/>
                        @error('cities')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-4">
                        <label class="form-label" for="postal_code">کدپستی</label>
                        <input type="text" name="postal_code" id="postal_code" class="form-control"/>
                        @error('postal_code')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-9 mb-3">
                        <label class="form-label" for="address">ادرس</label>
                        <textarea name="address" id="address" class="form-control"></textarea>
                        @error('address')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mb-4"> ثبت ادرس جدید</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-3 border-start bg-body-tertiary">
        <div class="ps-3 pt-3">
            <h4 class="border-bottom pb-3">سفارش شما:</h4>
        </div>
        <div class="bg-body-tertiary rounded-5">
            <div class="p-3 d-flex justify-content-between border-bottom">
                @foreach(session('cart') as $item)
                    <span>
                        {{$item['name']}}
                    </span>
                    <span class="text-danger ms-5">
                    {{$item['quantity']}} * {{$item['price']}}
                    </span>
                @endforeach
            </div>
            <div class="p-3 d-flex justify-content-between border-bottom">
                <span>مجموع قیمت ها : </span>
                <span id="totalPrices" class="text-danger ms-5">
                    @php
                        $totalPrices = 0;
                        foreach (session()->get('cart') as $cart){
                            $totalPrices += $cart['multiplyPrice'];
                        }
                    @endphp
                    {{$totalPrices}}
                </span>
            </div>
            <div class="p-3 d-flex justify-content-between border-bottom">
                <span>مجموع هزینه ارسال : </span>
                <span id="totalDeliveries" class="text-danger ms-5">
                    @php
                        $totalDelivery = 0;
                        foreach (session()->get('cart') as $cart){
                            if($cart['quantity'] > 1){
                                $totalDelivery += (($cart['quantity'] - 1) * $cart['delivery_amount_per_product']);
                            }
                            $totalDelivery += $cart['delivery_amount'];
                        }
                    @endphp
                    {{$totalDelivery}}
                </span>
            </div>

            <div class="p-3 d-flex justify-content-between border-bottom">
                <span>مبلغ کوپن : </span>
                <span id="couponAmount" class="text-danger ms-5">
                    @if(session()->has('coupon'))
                        {{session('coupon')['amount']}}
                    @else
                        0
                    @endif
                </span>
            </div>

            <div class="p-3 d-flex justify-content-between border-bottom">
                <span>جمع کل :</span>
                <span id="totalAmount" class="text-danger ms-5">
                    @if(session()->has('coupon'))
                        {{($totalPrices + $totalDelivery) - session('coupon')['amount']}}
                    @else
                        {{$totalPrices + $totalDelivery}}
                    @endif
                </span>
            </div>
            <div class="p-3">
                <div class="mb-4">
                    <div class="form-check pb-3">
                        <input class="form-check-input" type="radio" name="payment_method" value="zarinpal" id="zarinpal" checked>
                        <label class="form-check-label" for="zarinpal">
                            درگاه پرداخت زرین پال
                        </label>
                    </div>
                    <p>
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده
                        از
                        طراحان گرافیک است.
                    </p>
                </div>
                <div class="mb-4">
                    <div class="form-check pb-3">
                        <input class="form-check-input" type="radio" name="payment_method" value="pay" id="pay">
                        <label class="form-check-label" for="pay">
                            درگاه پرداخت پی
                        </label>
                    </div>
                    <p>
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده
                        از
                        طراحان گرافیک است.
                    </p>
                </div>
            </div>

            <div class="p-3 text-center">
                <a href="{{route('home.cart.checkout')}}" class="text-decoration-none btn btn-primary">سفارش</a>
            </div>
        </div>
    </div>
@endsection
