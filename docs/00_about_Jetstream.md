# Jetstream

## ドキュメント
本体のドキュメントから独立して作成されている  
https://readouble.com/jetstream/1.0/ja/introduction.html  

## Laravel Jetstream とは
標準的な認証関連機能をあらかじめ実装したスキャフォールド  
フロントエンドの実装にLivewire を使う場合と、Inertia.js を使う場合を選択できる

## Livewire とは
JavaScriptを使わずにSPAが実装できるLaravelのライブラリ  
実際にはalpine.jsなどが動いているが、Laravel側ではphp(bladeテンプレート)のみで作成できる  

## Inertia.js とは
Vue.js と組み合わせてSPAを実装できる  
Vue.js でやるべきことはコンポーネントの作成のみ
Vue.js のルーティング機能ではなく、Laravelのルーティングを利用できる  

## インストール手順
コマンドから実行
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

※ Sail 環境利用時は、先頭に`sail` コマンドをつけて、コンテナ内で実行させる  

## 余談
Inaertia (イナーシャ): 慣性
