<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\ImportBatch;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use \Carbon\Carbon;
use App\Sku;
use App\Stock;
use App\Value;
use Maatwebsite\Excel\Facades\Excel;


class UsersController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api', 'company']);
  }

  public function masters(Request $request)
  {
    $rolesController = new RolesController();
    $rolesResponse = $rolesController->index($request);
    $UsersController = new UsersController();
    $usersResponse = $UsersController->index($request);
   

   
    return response()->json([
      'roles'                 =>  $rolesResponse->getData()->data,
      'users'  =>  $usersResponse->getData()->data,

    ], 200);
  }

  /*
   * To get all the users
   *
   *@
   */
  public function index(Request $request)
  {

    $users = [];
    $users =  $request->company->users()->with('roles')
      ->whereHas('roles',  function ($q) {
        $q->where('name', '!=', 'Admin');
        $q->where('name', '!=', 'Super Admin');
      });
    // $count = 0;
    // $users = request()->company->users()->whereHas('roles',  function ($q) {
    //   $q->where('name', '!=', 'Admin');
    // });
    // if (request()->is_active != null) {
    //   $users =  $users->where('active', request()->is_active);
    // }
   

    // if (request()->roleId != null) {
    //   $users = $users->with('roles')
    //     ->whereHas('roles',  function ($q) {
    //       $q->where('roles.id', '=', request()->roleId);
    //     });
    // }

//     $users =  $users->latest()->get();
// return $users;
    if (request()->page && request()->rowsPerPage) {
      $count =  $users->count();
      $users =  $users->paginate(request()->rowsPerPage)->toArray();
      $users =  $users['data'];
    } else {
      $users =  $users->get();
      $count =  $users->count();
    }
    return response()->json([
      'data'  =>  $users,
      'count' =>   $count,
      'success' =>  true,
    ], 200);
  }

  

 
  /*
   * To store a new company user
   *
   *@
   */
  public function store(Request $request)
  {
    // $request->validate([
    //   'name'                    => ['required', 'string', 'max:255'],
    //   'email'                   => ['required', 'string', 'max:255', 'unique:users'],
    //   'role_id'                 =>  'required',
    // ]);

    $user['name'] = $request->name;
    $user['email'] = $request->email;
    $user['address'] = $request->address;
    $user['imei_no'] = $request->imei_no;
    $user['employee_code'] = $request->employee_code;
    $user['doj'] = $request->doj;
    $user['dob'] = $request->dob;
    $user['mim_id'] = $request->mim_id;
    $user['active'] = $request->active;
    $user['phone'] = $request->phone;
    $user['password'] = bcrypt('123456');
    // $user['password_backup'] = bcrypt('123456');

    $user = new User($user);
    // return $user;
    $user->save();
    $user->assignRole($request->role_id);
    $user->roles = $user->roles;
    $user->assignCompany($request->company->id);
    $user->companies = $user->companies;
    //  return $user;
    return response()->json([
      'data'     =>  $user
    ], 200);
  }

  /*
   * To show particular user
   *
   *@
   */
  public function show($id)
  {
    $user = User::where('id', '=', $id)
      ->with('roles', 'companies')->first();
// return $user;
    return response()->json([
      'data'  =>  $user,
      'success' =>  true
    ], 200);
  }

  /*
   * To update user details
   *
   *@
   */
  public function update(Request $request, User $user)
  {
    $request->validate([
      'name'                    => ['required', 'string', 'max:255'],
      'email'                   => ['required', 'string', 'max:255'],
    ]);

    $user->update($request->all());

    if ($request->role_id)
      $user->assignRole($request->role_id);

    $user->assignCompany(1);
    $user->roles = $user->roles;
    $user->companies = $user->companies;

    return response()->json([
      'data'  =>  $user,
      'message' =>  "User is Logged in Successfully",
      'success' =>  true
    ], 200);
  }

  /*
   * To check or update unique id
   *
   *@
   */
  public function checkOrUpdateUniqueID(Request $request, User $user)
  {
    if ($user->unique_id == null | $user->unique_id == '') {
      $user->update($request->all());
    }

    return response()->json([
      'data'  =>  $user,
      'success' =>  $user->unique_id == $request->unique_id ? true : false
    ], 200);
  }

  public function countUsers(Request $request)
  {
    $count = $request->company->users()
      ->whereHas('roles', function ($q) {
        $q->where('name', '=', 'Employee');
      })->count();

    return response()->json([
      'data'  =>  $count
    ], 200);
  }
  public function exports(Request $request)
  {
    $parameters = [
      'request' =>  $request,
    ];

    Excel::store(new UsersExport($parameters), "/cms/exports/UsersExport.xlsx", "s3");

    return response()->json([
      'data'  =>  env('AWS_LINK') . 'cms/exports/UsersExport.xlsx'
    ]);
  }
}
