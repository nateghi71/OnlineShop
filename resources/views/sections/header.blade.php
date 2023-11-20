<header class="header bg-black text-white py-2 px-4 clearfix d-flex">
    <h3 class="fs-4 float-start">{{$title}}</h3>
    <form action="#" method="post" class="ms-auto">
        @csrf
        <button type="submit" class="btn btn-link fs-5 text-decoration-none text-white">خروج</button>
    </form>
</header>
