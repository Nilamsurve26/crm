<?php

namespace App\Imports;

use App\CrudValue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class ValuesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $data = [
            'company_id'  => request()->company->id,
            'name' => $row['Name'],
        ];

        return new CrudValue($data);
    }

    public function headingRow(): int
    {
        return 2;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
