<?php

declare(strict_types=1);

namespace Modules\Objects\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Modules\Objects\Models\Objects;
use Modules\Objects\Resources\RowResource;


class ParseCsvFile implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected string $path;
    const VALID_LENGTH = 13;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function handle(): void
    {
        $fh = fopen(Storage::path($this->path), "r");
        // делаем пропуск первой строки, смещая указатель на одну строку
        fgetcsv($fh, 0, ';');
        //читаем построчно содержимое CSV-файла
        $result = [];
        while (($c_row = fgetcsv($fh, 0, ';')) !== false) {
            $row = [];
            for ($i = 0; $i < self::VALID_LENGTH; $i++) {
                $row[] = $c_row[$i];
            }
            //Проверка что у строки заполнен код (минимально валидируем)
            if ($row[0]) {
                $result[] = (new RowResource($row))->toArray();
            }
        }
        Objects::upsert($result, ['code'], config('objects.fields'));
    }
}
