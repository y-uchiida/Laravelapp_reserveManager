# 認可(Authorization)

## 認可とはなにか
その利用者が誰か、を判別する「認証」(Authentication)に対して、  
その利用者にどんな操作を認めるかを決めるのが認可(Authorization)  
Laravel では、`Gate` と `Policy` の二種類の認可の仕組みが提供されている

## Gate と Policy
### Gate
```
ゲートは、ユーザーが特定のアクションを実行することを許可されているかどうかを判断する単なるクロージャです。
通常、ゲートは、Gateファサードを使用してApp\Providers\AuthServiceProviderクラスのbootメソッド内で定義されます。
ゲートは常に最初の引数としてユーザーインスタンスを受け取り、オプションで関連するEloquentモデルなどの追加の引数を受け取る場合があります。
```

`AuthServiceProvider` クラスに記述したクロージャの関数内で、権限の有無を判定するロジックを記述し、  
権限があればtrue, なければfalse を返すようにする

```php
/* app/Providers/AuthServiceProvider.php */

/// (省略)

    public function boot()
    {
        $this->registerPolicies();

        /* Gate の定義は、 Gate::define('名称', function($user){ 認可のロジック }) を用いて行う
         * User モデルに追加したrole カラムを使って、ユーザーの権限レベルを判定するGateを作成する
         */

        /* システムマスター(admin)の権限がある場合 */
        Gate::define('admin', function ($user) {
            return $user->role === 1;
        });

        /* 管理運用者(manager)以上の権限がある場合 */
        Gate::define('manager-higher', function ($user) {
            return $user->role > 0 && $user->role <= 5;
        });

        /* 一般ユーザー(user)以上の権限がある場合 */
        Gate::define('user-higher', function ($user) {
            return $user->role > 0 && $user->role <= 9;
        });
    }

```

ログイン中のユーザーの情報でtrueが返れば権限あり、falseになれば権限なし、として扱える

### Gate の利用例(ルーティング)
```php

/* routes/web.php */

/* Gate の利用例
 * middleware('can:Gate名称')で、認可処理を行ってくれる
 */

/*
 * manager 以下のルートは、manager-higher のGate でtrue が返らないとアクセスできない
 * 認可が失敗した場合、403 エラーがレスポンスされる
 */
Route::prefix('manager')
->middleware('can:manager-higher')->group(function(){
    Route::get('index', function () {
        /* prefixがついているので、割当されるURLは /manager/index */
        dump('this user is manager role upper');
    });
});

/* user-higher のGate でtrue が返らないとアクセスできない */
Route::middleware('can:user-higher')
->group(function(){
    Route::get('index', function () {
        dd('this user is user role upper');
    });
});

```

### Gate の利用例(Viewテンプレート)
blade の`@can` ディレクティブを用いると、Gateで設定した認可ロジックを利用して表示を切り替えることができる
```html
{{-- manager-higher のGate でtrueを返されるユーザーでログインしていた場合に表示する --}}
@can('manager-higher')
<x-jet-nav-link href="{{ route('events.index') }}" :active="request()->routeIs('events.index')">
    イベント管理
</x-jet-nav-link>
@endcan
```

### Policy
Policy クラスとモデルやリソースの間に関連を持たせることで、複数の認可情報をPolicy クラス内に集約させることができるしくみ  
一定以上の複雑な認可を設定したい場合は、Policyを用いたほうがよい

```
ポリシーは、特定のモデルまたはリソースに関する認可ロジックを集めたクラスです。
たとえば、アプリケーションがブログの場合、App\Models\Postモデルと投稿の作成や更新などのユーザーアクションを認可するためのPostモデルと対応するApp\Policies\PostPolicyがあるでしょう。

make:policy　Artisanコマンドを使用してポリシーを生成できます。
生成するポリシーはapp/Policiesディレクトリへ配置します。このディレクトリがアプリケーションに存在しない場合、Laravelが作成します。

make:policyコマンドは、空のポリシークラスを生成します。リソースの表示、作成、更新、削除に関連するポリシーメソッドのサンプルを含んだクラスを生成する場合は、コマンドの実行時に--modelオプションを指定します。
```

make:policy コマンドの例
```bash
# 空のPostPolicy クラスを作成する
php artisan make:policy PostPolicy

# Post モデルに対する認可のテンプレートを含んだPostPolicyクラスを作成する
php artisan make:policy PostPolicy --model=Post
```

```
新しいLaravelアプリケーションに含まれているApp\Providers\AuthServiceProviderには、Eloquentモデルを対応するポリシーにマップするpoliciesプロパティが含まれています。
ポリシーを登録すると、特定のEloquentモデルに対するアクションを認可するときに使用するポリシーがLaravelに指示されます。
```

## 認可を設定する方法例：role という考え方
role は、権限レベルのようなもの  
ログインユーザーごとにroleを数値で割り当てて、その数値の大小で権限の有無を判定する  
たとえば1をもっとも強い権限レベル(admin)とし、9を最も弱い権限レベル(一般ユーザー)とする  
その中間の5に、システムの管理を行うユーザー(manager)の権限レベルを設定する  

role の設定の簡易な方法として、User モデルにrole のカラムを追加して、そこに設定を行う方法を取ることができる

## 参考ページ
- 認可 (Readouble):  
  https://readouble.com/laravel/9.x/ja/authorization.html

- Laravel ロールの設定 (Qiita):  
  https://qiita.com/yyy752/items/9f758a5266b2187179b2
