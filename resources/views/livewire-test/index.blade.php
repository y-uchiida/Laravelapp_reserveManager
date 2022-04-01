<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Livewire テスト</title>

    {{-- Livewire のcss要素を読み込み--}}
    @livewireStyles
</head>
<body>

    livewireテスト
    <div>
      @if (session()->has('message'))
          <div class="">
              {{ session('message') }}
          </div>
      @endif
    </div>

    {{-- Counter コンポーネントを読み込み --}}
    <livewire:counter />

    {{-- Livewire のJavaScript 要素(Alpine.js など)を読み込み --}}
    @livewireScripts
</body>
</html>
