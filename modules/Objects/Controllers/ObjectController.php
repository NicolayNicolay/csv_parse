<?php

declare(strict_types=1);

namespace Modules\Objects\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Objects\Models\Objects;
use Modules\Objects\Services\ObjectUploadService;

class ObjectController extends Controller
{
    private int $object_id = 0;
    private Objects $objects;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Objects $objects)
    {
        $this->middleware('auth');
        $route = Route::current();
        if ($route !== null && ! empty($route->parameters['id'])) {
            $this->object_id = (int) $route->parameters['id'];
        }
        $this->objects = $objects;
    }

    public function list(Request $request): LengthAwarePaginator
    {
        $per_page = config('app.per_page');
        return $this->objects->orderBy('id')->paginate($per_page);
    }

    public function store(Request $request): array
    {
        return (new ObjectUploadService($request))->save();
    }

    public function destroy(): void
    {
        $object = $this->objects->find($this->object_id);
        $object?->delete();
    }
}
