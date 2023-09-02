<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Value;
use App\CrudValue;
use App\Imports\ValuesImport;

class CrudValuesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'company'])
            ->except(['index']);
    }
    public function index()
    {
        return response()->json([
            'data'  =>  CrudValue::all()
        ]);
    }

    public function uploadValue(Request $request)
    {
        set_time_limit(0);
        if ($request->hasFile('valuesData')) {
            $file = $request->file('valuesData');
            Excel::import(new ValuesImport, $file);
            return response()->json([
                'data'    =>  CrudValue::all(),
                'success' =>  true
            ]);
        }
    }
    public function processValue()
    {
        set_time_limit(0);
        $crud_values = CrudValue::all();
        foreach ($crud_values as $value) {
            if ($value->name) {
                $gp = Value::where('name', '=', strtoupper($value->name))
                    ->where('company_id', '=', request()->company->id)
                    ->first();
                if (!$gp) {
                    $data  = new Value([
                        'name' => strtoupper($value->name),
                    ]);
                    request()->company->values()->save($data);
                }
            }
        }
    }

    public function truncate()
    {
        CrudValue::truncate();
    }
}
