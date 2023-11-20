<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script type="module">
        $(function (){
            $('.wrapper').css('min-height', $(document).outerHeight(true) - ($('.header').outerHeight(true) + $('.footer').outerHeight(true)));
        });
    </script>
    @yield('script')
</head>
<body>
    @include('sections.header' , ['title' => 'وبلاگ برنامه نویسی'])

    <div class="wrapper">
        @yield('content')
    </div>

    @include('sections.footer')
</body>
</html>
