# エラーページの編集

以下のartisan コマンドで、エラーページを編集できるようになる
```bash
php artisan vendor:publish --tag=laravel-errors
```

`resources/views/errors` にview ファイルがコピーされ、これを変更することでエラーページの内容を変えられる
