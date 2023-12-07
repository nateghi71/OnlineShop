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
            $('.wrapper').css('min-height', $(document).outerHeight(true) - ($('.header').outerHeight(true) + $('.navbar').outerHeight(true) + $('.footer').outerHeight(true)));
            $('.js-fullHeight').css('min-height', $(document).outerHeight(true) - ($('.header').outerHeight(true) + $('.navbar').outerHeight(true) + $('.footer').outerHeight(true)));
        });
    </script>
</head>
<body>

@include('sections.headerHome')
@include('sections.header' , ['title' => 'فروشگاه حسین'])

    <div class="w-100 row wrapper">
        @yield('content')
    </div>

    @include('sections.footer')
    @yield('script')
</body>
</html>
