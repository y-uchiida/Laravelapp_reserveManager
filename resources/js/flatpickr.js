import flatpickr from "flatpickr";

/* 日本語ロケールデータの読み込み */
import { Japanese } from "flatpickr/dist/l10n/ja.js";

/* #event_date の要素に対してflatpickrを適用 */
flatpickr("#event_date", {
    "locale": Japanese, // 日本語化対応
    minDate: "today", // 本日以降の日付のみ選択可能にする
    maxDate: new Date().fp_incr(30) // 本日から30日後までの日付を選択可能にする
});

/* #calendar の要素に対してflatpickrを適用 */
flatpickr("#calendar", {
    "locale": Japanese, // 日本語化対応
    minDate: "today", // 本日以降の日付のみ選択可能にする
    maxDate: new Date().fp_incr(30) // 本日から30日後までの日付を選択可能にする
});

/* 時間選択の設定を変数に格納 */
const timepicker_setting = {
    enableTime: true, // 時間選択を有効化
    noCalendar: true, // カレンダーを非表示にする(日付の選択をしない)
    dateFormat: "H:i", // HH:mm の形式
    time_24hr: true, // 24時間表記
    minTime: "10:00", // 選択可能な時刻を最小10:00に設定
    maxTime: "20:00", // 選択可能な時刻を最大20:00に設定
    minuteInclement: 30, // 分数の刻みを30分に設定
};

/* #start_time の要素に対してflatpickrを適用 */
flatpickr("#start_time", {
    "locale": Japanese,
    ...timepicker_setting
});

/* #start_time の要素に対してflatpickrを適用 */
flatpickr("#end_time", {
    "locale": Japanese,
    ...timepicker_setting
});

