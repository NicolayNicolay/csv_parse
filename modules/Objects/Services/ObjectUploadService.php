<?php

namespace Modules\Objects\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\Files\Models\TmpFile;
use Modules\History\Models\HistoryUpload;
use Illuminate\Http\Request;
use Modules\Objects\Models\Objects;
use Modules\Objects\Resources\RowResource;

class ObjectUploadService
{
    public int $file_id;
    public string $path;
    public Request $request;

    //Кол-во ключевых колонок файла
    const VALID_LENGTH = 13;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->getRequestFields();
    }

    //Сборка полей пришедших из формы
    public function getRequestFields(): void
    {
        $this->path = $this->request->post('file')['path'];
        $this->file_id = $this->request->post('file')['id'];
    }

    public function save(): array
    {
        $res = (new HistoryUpload())->create($this->getFieldsHistory());
        try {
            $this->parseFile();
            //TODO Оставляю пометку на развитие, для иных форматов (xlsx), или больших файлов целесообразние использовать Horizon (сервер очередей)
//            ParseCsvFile::dispatch($this->path)->onConnection('redis-long-running');
            //Обновим статус файла выгрузки
            $res->update(['status' => 1]);
            return ['status' => true];
        } catch (\Exception $exception) {
            Log::debug('errors:' . $exception->getMessage());
            return ['status' => false, 'errors' => $exception->getMessage()];
        }
    }

    public function parseFile(): bool
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
        return true;
    }

    public function getFieldsHistory(): array
    {
        return [
            'user_id' => Auth::user()->id,
            'file_id' => $this->file_id,
            'status'  => 1,
        ];
    }
}
