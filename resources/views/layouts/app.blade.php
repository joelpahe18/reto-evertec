<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" href="https://media-exp1.licdn.com/dms/image/C510BAQF-ww4C4B-1Vw/company-logo_200_200/0/1519939401352?e=2147483647&v=beta&t=k8ZA-zl1oKFjpFHT1AHBiMSVlXsAJfoFjPwRZyn0eQg" type="image/x-icon" />
    <link rel="shortcut icon" href="https://media-exp1.licdn.com/dms/image/C510BAQF-ww4C4B-1Vw/company-logo_200_200/0/1519939401352?e=2147483647&v=beta&t=k8ZA-zl1oKFjpFHT1AHBiMSVlXsAJfoFjPwRZyn0eQg" />

    <!-- responsive metatag -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/css/index.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <title>@yield('title', 'Reto Evertec')</title>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?= url('/') ?>">
            <img src="https://media-exp1.licdn.com/dms/image/C510BAQF-ww4C4B-1Vw/company-logo_200_200/0/1519939401352?e=2147483647&v=beta&t=k8ZA-zl1oKFjpFHT1AHBiMSVlXsAJfoFjPwRZyn0eQg" height="30" width="30" class="d-inline-block align-top" alt="">
            Reto Evertec
        </a>
    </nav><br />

    <div class="container">
        @yield('content')
    </div>

    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="/js/popper-1.12.9.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/fasterjs.js"></script>

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    @yield('footer')
</body>

</html>