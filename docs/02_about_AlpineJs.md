# Alpine.js

## Alpine.js とは
Vue.js に似た構文を持つ、リアクティブシステムを備えたJavaScript フレームワーク  
`v-on` の代わりに `x-on`を使うなど、vue.の経験があるとスムーズに使える  

## 導入手順
npm でインストールできる  
Laravel ではLivewireに含まれているので、それを使うことも多い  
今回はLivewire利用が前提なのでその手順で確認

```bash
 # Jetstream 本体のインストール
 $ composer require laravel/jetstream

 # フロントエンドの実装にlivewireを選択
 $ php artisan jetstream:install livewire

 # npmコマンドを実行してjsなどを展開
 $ npm install && npm run dev

 # Jetstream が生成したマイグレーションファイルを実行
 $ php artisan migrate
```

上記コマンド実行でnpmパッケージがインストールされ、さらに以下のコードが追記される
```JavaScript
/* resourse/js/app.js */
require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
```

利用したいbladeファイルで、以下を記述してよみこむ
```html
<script src="{{ mix('js/app.js') }}" defer></script>
```

実際には`@livewireScripts` なども一緒に利用することになるので、デフォルトで生成されるbladeのひな型を参考にするのがよい



## 参考ドキュメント
- Alpine.js 公式:
  https://alpinejs.dev/

- Readouble:
  https://readouble.com/livewire/2.x/ja/alpine-js.html

- Livewire:
  https://laravel-livewire.com/docs/2.x/alpine-js
