<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GenericExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        if ($this->data->isNotEmpty()) {
            $first = $this->data->first();

            return array_keys(is_array($first) ? $first : $first->toArray());
        }

        return [];
    }
}
