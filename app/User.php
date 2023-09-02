<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
'email',
'password',
'phone',
'mim_id',
'api_token',
'employee_code',
'dob',
'address',
'imei_no',
'doj',
'is_deleted',
'active',
'image_path'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  /*
   * To generate api token
   *
   *@
   */
  public function generateToken()
  {
    if ($this->api_token == null)
      $this->api_token = str_random(60);
    $this->save();
    return $this;
  }

  /*
   * A user belongs to many roles
   *
   *@
   */
  public function roles()
  {
    return $this->belongsToMany(Role::class)
      ->with('permissions');
  }

  /**
   * Assign role to user
   *
   * @ 
   */
  

  public function assignRole($role)
  {
    return $this->roles()->sync([$role]);
  }

  /**
   * Check if the user has role
   *
   * @ 
   */
  public function hasRole($roles)
  {
    return $this->roles ? in_array($roles, $this->roles->pluck('id')->toArray()) : false;
  }

  /*
   * An user belongs to many companies
   *
   *@
   */
  public function companies()
  {
    return $this->belongsToMany(Company::class);
  }

  /**
   * Assign company to user
   *
   * @ 
   */
  public function assignCompany($company)
  {
    return $this->companies()->sync([$company]);
  }

  /**
   * Check if the user has company
   *
   * @ 
   */
  public function hasCompany($company)
  {
    return $this->companies ? in_array($company, $this->companies->pluck('id')->toArray()) : false;
  }

  /*
   * A supervisor belongs to many user
   *
   *@
   */
  public function users()
  {
    return $this->belongsToMany(User::class, 'supervisor_user', 'supervisor_id', 'user_id');
  }

  /**
   * Assign supervisor to user
   *
   * @ 
   */
  public function assignSupervisor($supervisor)
  {
    return $this->supervisors()->sync([$supervisor]);
  }

  /**
   * Check if the user has supervisor
   *
   * @ 
   */
  public function hasSupervisor($supervisor)
  {
    return $this->supervisors ? in_array($supervisor, $this->supervisors->pluck('id')->toArray()) : false;
  }

  public function permissions()
  {
    return $this->belongsToMany(Permission::class);
  }

  public function assignPermission($permission)
  {
    $this->permissions()->syncWithoutDetaching([$permission]);
    $this->refresh();

    return $this;
  }

  public function unassignPermission($permission)
  {
    $this->permissions()->detach([$permission]);
    $this->refresh();

    return $this;
  }

  public function hasPermission($permission)
  {
    return $this->permissions ? in_array($permission, $this->permissions->pluck('id')->toArray()) : false;
  }
  public function tickets()
  {
    return $this->hasMany(Ticket::class)
      ->where('is_deleted', '=', FALSE);
  }
  public function values()
  {
    return $this->hasMany(Value::class);
  }
  public function value_lists()
  {
    return $this->hasMany(ValueList::class);
  }
  public function products()
  {
    return $this->hasMany(Product::class);
  }
}
