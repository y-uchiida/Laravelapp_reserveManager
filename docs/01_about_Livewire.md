# Livewire とは(おさらい)
JavaScriptを使わずにSPAが実装できるLaravelのライブラリ  
実際にはalpine.jsなどが動いているが、Laravel側ではphp(bladeテンプレート)のみで作成できる  

## ドキュメント
- Livewire 2.x クイックスタート - Readouble:  
  https://readouble.com/livewire/2.x/ja/quickstart.html  
- Livewire 公式サイト:  
  https://laravel-livewire.com/  

## Livewireのメリット
- PHP, Laravel のエンジニアのみ(フロントエンドの経験者がいない)場合でも、SPAを開発できる
- Bladeの中に組み込んで記述できる

## Livewireのデメリット
- 動作のたび、Ajaxが走るのでReactやVueなどと比較すると少し遅いと言われている
- Laravelのライブラリであるため、移植が難しい(バックエンドだけ差し替えるといったことができない)

## Livewireの利用開始手順
0. Livewire をインストール  
   JetSteamをインストールするとまとめて入ってくる  
   今回はJetStreamと併せて使うことを前提にする
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
1. コントローラを作成し、ルーティングも設定する  
   サンプルとして、`LiveWireTestController` を作成する
   ```bash
    $ php artisan make:controller LivewireTestController
   ```

  作成したコントローラに、以下のようにアクションメソッドを作成  
  ```php
  // LivewireTestController.php
  public function index(){
      return view('livewire-test.index');
  }
  ```
  viewファイルはあとの項目で作成する  

  アクションメソッドあてにルーティングを設定  
  ```php
  // web.php
  Route::controller(LivewireTestController::class)->prefix('livewire-test')->group(function(){
      /* 1つめのindex にはprefixで'livewire-test'が、
       * 2つめのindex にはRoute::controller() で LivewireTestController が自動的に付与される
       */
      Route::get('index', 'index');
  });

  
  ```

2. コンポーネントを作成する
   artisan コマンドで、Livewireコンポーネントを生成する
   ```bash
   $ php artisan make:livewire <コンポーネント名>
   ```
  ここでは、Livewireのドキュメントに沿って `Counter` コンポーネントを作成する  
  artisan コマンドで、以下の２つが生成される  

  - コンポーネントのロジック部分を記述するためのファイル
    `app\Http\Livewire\Counter.php`
  - コンポーネントの見映えを記述するbladeファイル
    `resources\views\livewire\couter.blade.php`

  `Counter.php` の内容は以下
  ```php
  <?php
  namespace App\Http\Livewire;

  use Livewire\Component;

  /* class内にいろいろなメソッドを追加記述することで利アクティブな動作を実装していく */
  class Counter extends Component
  {
    /* 初期状態では、render() から、view ファイルを返すのみ */
    public function render()
    {
        return view('livewire.counter');
    }
  }
  ```

3. bladeテンプレートで view を作成する
   Livewireコンポーネントを動作させるために、以下の内容を記述する
   ```php
   <head>
   // headタグ内に　@livewireStyles ディレクティブを記述する
   @livewireStyles
   </head>
   
   <body>

   // <livewire:コンポーネント名 /> の形式で、ブレード内にLivewire コンポーネントを読み込みする
   // @livewire('コンポーネント名') と記述することもできる
   <livewire:counter />

   // body タグ末尾などに @livewireScripts ディレクティブを記述する
   @livewireScripts
   </body>
   ```

4. ライフサイクルフック
   コンポーネントのライフサイクルに沿って実行されるメソッドが用意されている  
   それらをLivewire コンポーネントクラスに実装すると、そのライフサイクル発生時に実行される  
   よく利用するのは以下
   - boot
   - mount
   - updated

   Livewire 2.x ライフサイクルのフック:  
   https://readouble.com/livewire/2.x/ja/lifecycle-hooks.html

5. アクション  
   コンポーネントのblade テンプレートでブラウザのイベントの発生を検知し、そのタイミングで実行したい処理を記述しておく  
   blade内の要素に、以下の形式で記述しておく
   ```
   wire:[ディスパッチされたブラウザイベント]="[アクション]"

   # input にフォーカスがある状態でEnterキーを押したとき、コンポーネントのdoSomething() メソッドを実行する場合
   <input wire:keydown.enter="doSomething">
   ```

## その他のLivewireの機能まとめ
慣れたユーザー向けに、リファレンスとして内容がまとまっている  
Livewire 2.x リファレンス:  
https://readouble.com/livewire/2.x/ja/reference.html  

## 参考ページ
- Laravel8でLivewireの使い方を学ぶ:  
  https://reffect.co.jp/laravel/laravel-livewire
  こちらもわかりやすくまとまっている
