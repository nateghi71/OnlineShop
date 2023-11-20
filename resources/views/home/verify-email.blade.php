@extends('layouts.home')

@section('scripts')
@endsection

@section('content')
    <div class="text-center pt-5">
        @if(session()->has('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif
        <p class="fs-4">ابتدا ایمیل خود را تایید کنید لینک تایید ایمیل برای شما ارسال شده است.</p>
        <form action="{{route('verification.send')}}" method="post">
            @csrf
            <button type="submit" class="btn btn-outline-primary">ارسال دوباره ایمیل</button>
        </form>
    </div>
@endsection
