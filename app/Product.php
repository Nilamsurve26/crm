<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'company_id',
        'created_by_id',
        'imagepath_1',
        'imagepath_2',
        'imagepath_3',
        'imagepath_4',
        'name',
        'short_description',
        'description',
        'brand_id',
        'barcode',
        'is_deleted',
        'is_active',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function created_by()
    {
        return $this->belongsTo(User::class);
    }
    public function brand()
    {
        return $this->belongsTo(ValueList::class);
    }
    public function product_issue_lists()
    {
      return $this->hasMany(ProductIssue::class);
       
    }
    
}
