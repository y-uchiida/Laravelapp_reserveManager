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

## x-data
`x-data={ var:val }` の形式でデータをhtmlに持たせる  
`x-data` を設置した要素の内側で、この変数をリアクティブに操作できる  
そのため、ページ全体で共有したいような変数はbody や画面全体のwraperに設定する  

## イベント
`x-on:click=" console.log('clicked'); "` のように、`x-on:イベント名` でブラウザイベントをリッスンできる  
Vue.jsと同じく、省略記法は `@click="..."`  

## Livewireで発生させたブラウザイベントのリッスン
Livewire コンポーネントで、以下のように記述するとブラウザイベントを発生させることができる
```php
$this->dispatchBrowserEvent('event_name', ['var' => $value]);
```
実際にはカスタムイベントを作成してwindowに発火させているということだと思う

vanilla JSで、以下のようにイベントをリッスンできる
```JavaScript
window.addEventListener('event_name', event => {
    console.log(`event_name emitted... var is ${event.detail.var}`);
});
```

Alpine.js の場合は以下
```html
<div @event_name.window=" event_name emitted ">
</div>
```

## 参考ドキュメント
- Alpine.js 公式:
  https://alpinejs.dev/

- Readouble:
  https://readouble.com/livewire/2.x/ja/alpine-js.html

- Livewire:
  https://laravel-livewire.com/docs/2.x/alpine-js
