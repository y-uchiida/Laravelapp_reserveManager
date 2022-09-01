# ページネーションのカスタマイズ

以下のartisan コマンドで、エラーページを編集できるようになる
```bash
php artisan vendor:publish --tag=laravel-pagination
```

`resources/views/vendor/pagination` にview ファイルがコピーされ、これを変更することでページネーションのコンポーネントの内容を変更できる

利用しているCSSフレームワークごとにファイルが分かれている  
たとえばTailwind を利用している場合は、`tailwind.blade.php` を編集する
