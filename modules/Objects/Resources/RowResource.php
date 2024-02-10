<?php

declare(strict_types=1);

namespace Modules\Objects\Resources;

use Carbon\Carbon;
use Modules\System\Resources\AbstractResource;

class RowResource extends AbstractResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'code'         => $this->data[0],
            'name'         => $this->data[1],
            'level_first'  => $this->data[2],
            'level_second' => $this->data[3],
            'level_third'  => $this->data[4],
            'price'        => $this->data[5],
            'price_cp'     => $this->data[6] ? str_replace('"', '', $this->data[6]) : '',
            'count'        => $this->data[7],
            'properties'   => $this->data[8],
            'unit'         => $this->data[10] ? str_replace('"', '', $this->data[10]) : '',
            'images'       => $this->data[11],
            'show_main'    => $this->data[12],
        ];
    }
}
