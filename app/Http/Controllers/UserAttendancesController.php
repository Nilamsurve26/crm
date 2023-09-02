<?php

namespace App\Http\Controllers;

use App\UserAttendance;
use Illuminate\Http\Request;

class UserAttendancesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'company']);
    }
    /*
   * To get all userAttendances
     *
   *@
   */
    public function index(Request $request)
    {

        $count = 0;
        $userAttendances = request()->company->user_attendances();


        if (request()->page && request()->rowsPerPage) {
            $count = $userAttendances->count();
            $userAttendances = $userAttendances->paginate(request()->rowsPerPage)->toArray();
            $userAttendances = $userAttendances['data'];
        } else {
            $userAttendances = $userAttendances->get();
            $count = $userAttendances->count();
        }
        return response()->json([
            'data'     => $userAttendances,
            'count' => $count,
            'success'   =>  true
        ], 200);
    }

    /*
   * To store a new userAttendance
   *
   *@
   */
    public function store(Request $request)
    {
        $request->validate([

            'ticket_id' =>  'required',
            'user_id' =>  'required',
        ]);
        $userAttendance = new UserAttendance(request()->all());


        $request->company->user_attendances()->save($userAttendance);
        return response()->json([
            'data'    => $userAttendance,

        ], 201);
    }

    /*
   * To view a single userAttendance
   *
   *@
   */

    public function show(UserAttendance $userAttendance)
    {
        return response()->json([
            'data'   => $userAttendance,
            'success' =>  true
        ], 200);
    }

    /**
     * To update a userAttendance
     *
    
     */
    public function update(Request $request, UserAttendance $userAttendance)
    {
        $request->validate([
            'ticket_id' =>  'required',
            'user_id' =>  'required',

        ]);
        $userAttendance->update($request->all());
        return response()->json([
            'data'  =>  $userAttendance

        ], 200);
    }


}
