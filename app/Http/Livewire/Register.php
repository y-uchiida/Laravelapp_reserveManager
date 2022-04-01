<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public $name;
    public $email;
    public $password;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ];

    public function updated($property)
    {
        /* validateOnly() で、変更されたデータだけバリデーションを行う */
        $this->validateOnly($property);
    }

    public function register()
    {
        $this->validate();

        /* バリデーション成功の場合、その内容でユーザーを作成する */
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        session()->flash('message', '登録okです');

        /* to_route() メソッドで、名前を付けたルーティング先にリダイレクトできる */
        return to_route('livewire-test.index');

    }

    public function render()
    {
        return view('livewire.register');
    }
}
