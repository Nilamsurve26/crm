<?php

namespace App\Exports;

use App\Http\Controllers\UsersController;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;

class UsersSheet implements FromView, ShouldAutoSize, WithStyles, WithTitle
{

    protected $users;

    public function __construct($parameters)
    {
        $request = $parameters['request'];

        $usersController = new UsersController();
        $usersResponse = $usersController->index($request);
        $this->users = $usersResponse->getData()->data;
        // return $this->users;
       
    }

    public function styles(Worksheet $sheet)
    {
        // This is to get the border for the complete excel
        $totalRow       = sizeof($this->users) + 1;
        $cellRange      = 'A1:K' . $totalRow;
        $sheet->getStyle($cellRange)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        return [
            1    => [
                'font' => [
                    'bold' => true,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => '80FFFF00']
                ]
            ],
        ];
    }

    public function view(): View
    {
        $users = $this->users;
        return view('exports.users_e', compact('users'));
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Users Data';
    }
}
