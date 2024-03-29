<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'event_name' => ['required', 'max:50'],
            'information' => ['required', 'max:200'],
            'event_date' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['required', 'after:start_time'], // 開始時刻の選択内容よりも未来の時刻になっていること
            'max_people' => ['required', 'numeric', 'between:1,20'],
            'is_visible' => ['required', 'boolean']
        ];
    }
}
