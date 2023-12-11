@extends('layouts.home')

@section('headers')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('script')
    <script type="module">
        $('#quantity').on('change' , changeCart)
        $('#remove_cart').on('click' , changeCart)
        $('#couponBtn').on('click' , changeCart)

        function changeCart(e)
        {
            e.preventDefault();
            let formData = new FormData(this.form)
            $.ajax({
                method:"post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:this.form.action,
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache:false,
                success:function (response){
                    console.log(@json(session('coupon')))
                    if(response.couponMessage)
                    {
                        $('#couponAmount').text(response.couponMessage.couponAmount)
                        $('#totalPrices').text(response.couponMessage.totalPrice)
                        $('#totalDeliveries').text(response.couponMessage.totalDelivery)
                        $('#totalAmount').text(response.couponMessage.totalAmount)
                    }
                    else
                    {
                        let result = Object.entries(response);
                        console.log(result)
                        if(result.length > 0)
                        {
                            let carts = '';
                            let totalPrice = 0;
                            let totalDelivery = 0;
                            $('#cart_rows').empty();
                            result.forEach(function (item){
                                carts += createCart(item[0],item[1]);
                                totalPrice += item[1]['multiplyPrice']
                                totalDelivery += item[1]['delivery_amount']
                                if(item[1]['quantity'] > 1)
                                    totalDelivery += (item[1]['quantity'] - 1) * item[1]['delivery_amount_per_product']
                            })
                            let couponAmount = Number.parseInt($('#couponAmount').text());
                            let totalAmount = (totalPrice + totalDelivery) - couponAmount;
                            $('#cart_rows').append(carts)
                            $('#quantity').on('change' , changeCart)
                            $('#remove_cart').on('click' , changeCart)
                            $('#totalPrices').text(totalPrice)
                            $('#totalDeliveries').text(totalDelivery)
                            $('#totalAmount').text(totalAmount)
                        }
                        else
                        {
                            $('#cart_wrapper').html('<div class="text-center text-danger"> سبد خرید خالی می باشد.</div>');
                        }
                    }
                },
                error:function (xhr, ajaxOptions, thrownError){
                    console.log("error: " + xhr.status)
                },
            })
        }

        function createCart(key , cart)
        {
            let html =
                        '<tr>' +
                            '<th>' +
                                cart.name +
                            '</th>' +
                            '<th>' +
                            cart.price +
                            '</th>' +
                            '<th>' +
                                '<form action="{{route('home.cart.update' , ['rowId' => 'key'])}}" method="post">'.replace("key", key) +
                                    '<input type="hidden" name="_method" value="PUT">'+
                                    '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
                                    '<input id="quantity" type="number" name="quantity" value="'+ cart.quantity +'" class="form-control">' +
                                '</form>' +
                            '</th>' +
                            '<th>' +
                                cart.multiplyPrice +
                            '</th>' +
                            '<th>' +
                                '<form action="{{route('home.cart.remove' , ['rowId' => 'key'])}}" method="post">'.replace("key", key) +
                                    '<input type="hidden" name="_method" value="DELETE">'+
                                    '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
                                    '<button id="remove_cart" type="button" class="btn btn-link text-danger text-decoration-none">X</button>' +
                                '</form>' +
                            '</th>' +
                        '</tr>';
                        ;
            return html;
        }

    </script>
@endsection

@section('content')
    <div id="cart_wrapper" class="p-4">
        @if(session()->has('cart') && count(session()->get('cart')) > 0)
            <table class="table table-bordered text-center">
                <thead>
                <tr>
                    <th>نام</th>
                    <th>فی</th>
                    <th>تعداد</th>
                    <th>قیمت</th>
                    <th>حذف</th>
                </tr>
                </thead>
                <tbody id="cart_rows">
                @foreach(session()->get('cart') as $key => $cartItem)
                    <tr>
                        <th>
                            {{$cartItem['name']}}
                        </th>
                        <th>
                            {{$cartItem['price']}}
                        </th>
                        <th>
                            <form action="{{route('home.cart.update' , ['rowId' => $key])}}" method="post">
                                @csrf
                                @method('PUT')
                                <input id="quantity" type="number" name="quantity" value="{{$cartItem['quantity']}}" class="form-control">
                            </form>
                        </th>
                        <th>
                            {{$cartItem['multiplyPrice']}}
                        </th>
                        <th>
                            <form action="{{route('home.cart.remove' , ['rowId' => $key])}}" method="post">
                                @csrf
                                @method('delete')
                                <button id="remove_cart" type="button" class="btn btn-link text-danger text-decoration-none">X</button>
                            </form>
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <hr class="mt-5">
            <div class="px-5 mt-5">
                <div class="d-flex justify-content-between">
                    <div>
                        <form action="{{route('home.cart.applyCoupon')}}" method="post" class="bg-body-tertiary p-3 rounded-5">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="code">کوپن</label>
                                <input type="text" name="code" id="code" class="form-control"
                                value="{{session()->has('coupon') ? session('coupon')['code'] : ''}}"/>
                                @error('code')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button id="couponBtn" type="button" class="btn btn-primary mb-4">اعمال</button>
                        </form>
                    </div>
                    <div class="bg-body-tertiary rounded-5">
                        <div class="p-3 d-flex justify-content-between border-bottom">
                            <span>مجموع قیمت ها : </span>
                            <span id="totalPrices" class="text-danger ms-5">
                                {{totalPrice()}}
                            </span>
                        </div>
                        <div class="p-3 d-flex justify-content-between border-bottom">
                            <span>مجموع هزینه ارسال : </span>
                            <span id="totalDeliveries" class="text-danger ms-5">
                                {{totalDelivery()}}
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
                                    {{(totalPrice() + totalDelivery()) - session('coupon')['amount']}}
                                @else
                                    {{totalPrice() + totalDelivery()}}
                                @endif

                            </span>
                        </div>
                        <div class="p-3 text-center">
                            <a href="{{route('home.cart.checkout')}}" class="text-decoration-none btn btn-primary">ادامه فرآیند خرید</a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center text-danger"> سبد خرید خالی می باشد.</div>
        @endif
    </div>
@endsection
