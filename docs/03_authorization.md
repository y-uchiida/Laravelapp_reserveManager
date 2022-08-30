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

ログイン中のユーザーの情報でtrueが返れば権限あり、falseになれば権限なし、として扱える


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
```
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
