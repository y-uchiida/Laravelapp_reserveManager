<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate; // ← シンプルな認可の仕組み Gate を利用するためのファサード

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
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
}
