<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    protected $fillable = [
        'company_id',
        'title',
        'sub_title',
        'description',
        'code',
        'created_by_id',
        'is_active',
        'is_deleted',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function created_by()
    {
      return $this->belongsTo(User::class);
    }
    public function value_lists()
  {
    return $this->hasMany(ValueList::class);
  }
}
