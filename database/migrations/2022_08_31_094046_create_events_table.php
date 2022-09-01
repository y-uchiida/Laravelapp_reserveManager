<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('イベント名');
            $table->text('information')->comment('イベント詳細');
            $table->integer('max_people')->comment('最大参加人数(予約枠数)');
            $table->datetime('start_date')->comment('予約開始日時');
            $table->datetime('end_date')->comment('予約終了日時');
            $table->boolean('is_visible')->comment('表示可否');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
