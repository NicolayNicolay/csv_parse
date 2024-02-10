<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('objects', function (Blueprint $table) {
            $table->id();
            $table->string('code')->comment('Код');
            $table->string('name')->comment('Наименование');
            $table->string('level_first')->comment('Уровень1');
            $table->string('level_second')->nullable()->comment('Уровень2');
            $table->string('level_third')->nullable()->comment('Уровень3');
            $table->string('price')->nullable()->comment('Цена');
            $table->string('price_cp')->nullable()->comment('ЦенаСП');
            $table->float('count')->nullable()->comment('Количество');
            $table->longText('properties')->nullable()->comment('Поля свойств');
            $table->longText('join_purchases')->nullable()->comment('Совместные покупки');
            $table->string('unit')->nullable()->comment('Единица измерения');
            $table->string('images')->nullable()->comment('Картинка');
            $table->boolean('show_main')->nullable()->comment('Выводить на главной');
            $table->text('description')->nullable()->comment('Описание');
            $table->unique('code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objects');
    }
};
