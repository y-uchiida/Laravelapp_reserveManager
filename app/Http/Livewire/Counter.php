<?php

namespace App\Http\Livewire;

use Livewire\Component;

/* class内にいろいろなメソッドを追加記述することで利アクティブな動作を実装していく */
class Counter extends Component
{
    /* クラスのプロパティが、コンポーネントのデータになる */
    public $count = 0;
    public $name = '';

    /* ライフサイクルフック */
    public function mount() /* コンポーネントのレンダリング前に一度実行される */
    {
        $this->name = 'mount';
    }
    public function updated() /* コンポーネントの内容が変更されるたびに実行される */
    {
        $this->name = 'updated';
    }

    /* マウスオーバーされたとき用のアクション */
    public function mouseOver()
    {
        $this->name = 'mouseover';
    }

    /* バインドしたカウンター変数を増加させるアクション */
    public function increment()
    {
        $this->count++;
    }

    /* 初期状態では、render() から、view ファイルを返すのみ */
    public function render()
    {
        return view('livewire.counter');
    }
}
