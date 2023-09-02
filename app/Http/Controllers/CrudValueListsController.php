<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Value;
use App\ValueList;
use App\Imports\ValueListsImport;
use App\CrudValueList;
use Maatwebsite\Excel\Facades\Excel;

class CrudValueListsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'company'])
            ->except(['index']);
    }
    public function index()
    {
        return response()->json([
            'data'  =>  CrudValueList::all()
        ]);
    }

    public function uploadValueList(Request $request)
    {
        set_time_limit(0);
        if ($request->hasFile('valueListsData')) {
            $file = $request->file('valueListsData');
            Excel::import(new ValueListsImport, $file);

            return response()->json([
                'data'    =>  CrudValueList::all(),
                'success' =>  true
            ]);
        }
    }
    public function processValueList()
    {
        set_time_limit(0);

        $crud_value_lists = CrudValueList::all();

        foreach ($crud_value_lists as $valueListsData) {
            if ($valueListsData->description) {


                $gp = ValueList::where('description', '=', strtoupper($valueListsData->description))
                    ->where('company_id', '=', request()->company->id)
                    ->where('is_deleted', false)
                    ->first();
                if (!$gp) {

                    $VALUE = Value::where('name', '=', strtoupper($valueListsData->value_name))
                        ->where('company_id', '=', request()->company->id)
                        ->where('is_deleted', false)
                        ->first();
                    if ($VALUE == '' || $VALUE == null) {
                        $VALUE  = new Value([
                            'name'  =>  strtoupper($valueListsData->value_name)
                        ]);
                        request()->company->values()->save($VALUE);
                    }

                    // $data['value_id'] = $VALUE['id'];

                    $data = [
                        'company_id' => request()->company->id,
                        'value_id' => $VALUE['id'],
                        'description'    => strtoupper($valueListsData->description),
                        'code'    => $valueListsData->code,
                    ];

                    $gp = new ValueList($data);
                    $gp->save();
                }
            }
        }
    }

    public function truncate()
    {
        CrudValueList::truncate();
    }
}
