<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Livewire user register samaple</title>

    {{-- app.css, app.js を読み込んで、Tailwindが動作するようにしておく --}}
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @livewireStyles
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body>
    livewireテスト <span class="text-blue-600">register</span>
    @livewire('register')

    @livewireScripts
</body>
</html>
