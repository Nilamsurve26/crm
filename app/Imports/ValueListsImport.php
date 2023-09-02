<?php

namespace App\Imports;

use App\CrudValueList;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class ValueListsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $data = [
            'company_id'  => request()->company->id,
            'value_name' => $row['VALUE NAME'],
            'description' => $row['DESCRIPTION'],
            'code'    => $row['CODE'],
        ];

        return new CrudValueList($data);
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
