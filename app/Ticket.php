<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
  protected $fillable = [
    'company_id',
    'title',
    'description',
    'issued_type_id',
    'status_type_id',
    'image_path_1',
    'image_path_2',
    'image_path_3',
    'image_path_4',
    'image_path_5',
    'image_path_6',
    'image_path_7',
    'image_path_8',
    'image_path_9',
    'image_path_10',
    'video_path',
    'created_by_id',
    'assigned_to_id',
    'is_deleted',
    'is_active',
    'priority_type_id',
  ];
  public function company()
  {
    return $this->belongsTo(Company::class);
  }
  public function created_by()
  {
    return $this->belongsTo(User::class);
  }
  public function assigned_to()
  {
    return $this->belongsTo(User::class);
  }
  // public function issued_type()
  // {
  //   return $this->belongsTo(ValueList::class);
  // }
  public function status_type()
  {
    return $this->belongsTo(ValueList::class);
  }
  public function priority_type()
  {
    return $this->belongsTo(ValueList::class);
  }
  public function user_attendances()
  {
    return $this->hasMany(UserAttendance::class)
      ->with('user');
  }
}
