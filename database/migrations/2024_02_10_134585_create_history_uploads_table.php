<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('history_uploads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('Пользователь выполнивший выгрузку');
            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->unsignedBigInteger('file_id')->comment('Файл по которому происходила выгрузка');
            $table->foreign('file_id')
                ->references('id')->on('tmp_files');
            $table->boolean('status')->default(false)->comment('Статус обработки файла');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('history_uploads');
    }
};
