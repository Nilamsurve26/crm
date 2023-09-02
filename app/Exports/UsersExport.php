<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UsersExport implements WithMultipleSheets
{
    use Exportable;

    public $parameters;

    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new UsersSheet($this->parameters);
        return $sheets;
    }
}
