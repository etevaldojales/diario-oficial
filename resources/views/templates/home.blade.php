<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diário Oficial</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}" media="screen"/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" media="screen"/>    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="screen"/>
    <script src="{{ asset('js/jquery.js')}}"></script>
    @yield('scripts')
</head>
<body>
    @yield('content')

    <footer>
        <div>
        <p class="rodape">Diario Oficial &copy; 2024</p>
        </div>
    </footer>
</body>
</html>