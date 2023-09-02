<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ValueList extends Model
{
  protected $fillable = [
    'company_id',
    'value_id',
    'code',
    'description',
    'is_deleted',
    'is_active',
    'created_by_id',
    'title',
  ];

  public function company()
  {
    return $this->belongsTo(Company::class);
  }

  public function value()
  {
    return $this->belongsTo(Value::class);
  }
  public function tickets()
  {
    return $this->hasMany(Ticket::class)
      ->where('is_deleted', '=', FALSE);
  }
  public function created_by()
  {
    return $this->belongsTo(User::class);
  }
  public function products()
  {
    return $this->hasMany(Product::class);
  }
}
