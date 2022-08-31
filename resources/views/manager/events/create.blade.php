<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            イベント新規作成
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="max-w-2xl py-4 mx-auto">
                    <x-jet-validation-errors class="mb-4" />

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('events.store') }}">
                        @csrf

                        <div>
                            <x-jet-label for="event_name" value="イベント名" />
                            <x-jet-input id="event_name" class="block mt-1 w-full" type="text" name="event_name"
                                :value="old('event_name')" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="information" value="イベント詳細" />
                            <x-textarea row="3" id="information" class="block mt-1 w-full" name="information"
                                required>{{ old('information') }}</x-textarea>
                        </div>

                        <div class="md:flex justify-between">
                            <div class="mt-4">
                                <x-jet-label for="event_date" value="イベント日付" />
                                <x-jet-input id="event_date" class="block mt-1 w-full" type="text" name="event_date"
                                    :value="old('event_date')" required />
                            </div>

                            <div class="mt-4">
                                <x-jet-label for="start_time" value="開始時刻" />
                                <x-jet-input id="start_time" class="block mt-1 w-full" type="text" name="start_time"
                                    :value="old('start_time')" required />
                            </div>

                            <div class="mt-4">
                                <x-jet-label for="end_time" value="終了時刻" />
                                <x-jet-input id="end_time" class="block mt-1 w-full" type="text" name="end_time"
                                    :value="old('end_time')" required />
                            </div>
                        </div>

                        <div class="md:flex justify-between items-end">
                            <div class="mt-4">
                                <x-jet-label for="max_people" value="最大参加人数(予約枠数)" />
                                <x-jet-input id="max_people" :value="old('max_people')" class="block mt-1 w-full" type="text"
                                    name="max_people" required />
                            </div>
                            <div class="flex space-x-4 justify-around">
                                <input type="radio" name="is_visible" value="1" id="is_visible"
                                    @if (!(old('is_visible') === '0')) checked @endif> 表示
                                <input type="radio" name="is_visible" value="0" id="is_visible"
                                    @if (old('is_visible') === '0') checked @endif> 非表示
                            </div>
                            <x-jet-button class="ml-4">
                                新規登録
                            </x-jet-button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- flatpickr のjsファイルをロード --}}
    <script src="{{ mix('js/flatpickr.js') }}"></script>
</x-app-layout>
