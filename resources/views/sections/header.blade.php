<header class="header bg-black text-white py-2 px-4 clearfix d-flex">
    <h3 class="fs-4 float-start">{{$title}}</h3>
    @if(auth()->check())
        <div class="ms-auto">
            <form action="{{route('logout')}}" method="post" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger text-decoration-none">خروج</button>
            </form>
            <a href="{{route('home.profile.index')}}" class="btn btn-success text-decoration-none">پروفایل</a>
        </div>
    @else
    <div class="ms-auto">
        <a href="{{route('login')}}" class="btn btn-info text-decoration-none">ورود</a>
        <a href="{{route('register')}}" class="btn btn-info text-decoration-none">ثبت نام</a>
    </div>
    @endif
</header>
