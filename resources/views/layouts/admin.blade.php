<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('headers')
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script type="module">
        $(function (){
            $('.js-fullHeight').css('min-height', $(document).outerHeight() - ($('.header').outerHeight() + $('.footer').outerHeight()));
        });
    </script>
</head>
<body>
@include('sections.header' , ['title' => 'پیکربندی سایت'])

<div class="w-100 row">
    <div class="col-3">
        @include('sections.sidebar')
    </div>
    <div class="col-9">
        <div class=" m-3">
            @yield('content')
        </div>
    </div>
</div>

@include('sections.footer')
@yield('script')
</body>
</html>
