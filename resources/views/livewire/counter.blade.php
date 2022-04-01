<div style="text-align: center">
    <button wire:click="increment">+</button>
    <h1>{{ $count }}</h1>
    <div class="mb-8"></div>

    こんにちは、{{ $name }}さん<br>
    <input type="text" wire:model="name">
    {{-- <input type="text" wire:model.debounce.2000ms="name"> --}} {{-- 2000ms待ってからバインド実行 --}}
    {{-- <input type="text" wire:model.lazy="name"> --}}  {{-- フォーカスが外れてから --}}
    {{-- <input type="text" wire:model.defer="name"> --}}  {{-- 送信処理される直前に実行(action が実行されるまで遅延) --}}
    <br>
    <button wire:mouseover="mouseOver">マウスを合わせてね</button>
</div>
