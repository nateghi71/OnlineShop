@extends('layouts.home')

@section('headers')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('script')
    <script type="module">
        $('#quantity').on('change' , changeCart)
        $('#remove_cart').on('click' , changeCart)

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
                    let result = Object.entries(response);
                    console.log(response)
                    console.log(result)
                    let carts = '';
                    $('#cart_rows').empty();
                    if(result.length > 0){
                        result.forEach(function (item){
                            carts += createCart(item[0],item[1]);
                        })
                    }
                    else{
                        carts = '<div class="text-center text-danger"> سبد خرید خالی می باشد.</div>';
                    }

                    $('#cart_rows').append(carts)
                    $('#quantity').on('change' , changeCart)
                    $('#remove_cart').on('click' , changeCart)
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
                                '<form action="{{route('home.cart.update' , ['rowId' => 'key'])}}" method="post">'.replace("key", key) +
                                    '<input type="hidden" name="_method" value="PUT">'+
                                    '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
                                    '<input id="quantity" type="number" name="quantity" value="'+ cart.quantity +'" class="form-control">' +
                                '</form>' +
                            '</th>' +
                            '<th>' +
                                cart.price +
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
    @if(session()->has('cart') && count(session()->get('cart')) > 0)
        <div class="p-4">
            <table class="table table-bordered text-center">
                <tbody id="cart_rows">
                @foreach(session()->get('cart') as $key => $cartItem)
                    <tr>
                        <th>
                            {{$cartItem['name']}}
                        </th>
                        <th>
                            <form action="{{route('home.cart.update' , ['rowId' => $key])}}" method="post">
                                @csrf
                                @method('PUT')
                                <input id="quantity" type="number" name="quantity" value="{{$cartItem['quantity']}}" class="form-control">
                            </form>
                        </th>
                        <th>
                            {{$cartItem['price']}}
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
        </div>
    @else
        <div class="pt-4 text-center text-danger"> سبد خرید خالی می باشد.</div>
    @endif
@endsection
