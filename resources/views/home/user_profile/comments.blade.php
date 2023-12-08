@extends('layouts.home')

@section('script')
@endsection

@section('content')
    <div class="col-sm-2">
        @include('sections.profile_sidebar')
    </div>
    <div class="col-sm-10">
        <div class="row p-3">
            <div class="d-flex justify-content-center">
                <div class="col-md-8 my-4">
                    @foreach($comments as $comment)
                        <div class="bg-body-secondary rounded-3 px-3 py-2 mt-3">
                            <div class="d-flex justify-content-between border-bottom pb-3">
                                <div class="ps-3">
                                    {{ $comment->product->name}}
                                </div>
                                <div dir="ltr">
                                    @php
                                        $userRate = \App\Models\ProductRate::where('product_id' , $comment->product->id)->where('user_id' , $comment->user->id)->first()->rate ?? 0;
                                    @endphp
                                    <span>
                                        @foreach(range(1,5) as $i)
                                            @if($userRate >0)
                                                <i class="fa fa-star"></i>
                                            @else
                                                <i class="fa fa-star-o"></i>
                                            @endif
                                            @php $userRate--; @endphp
                                        @endforeach
                                    </span><br>
                                </div>
                            </div>
                            <p class="m-3">
                                {{$comment->text}}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
