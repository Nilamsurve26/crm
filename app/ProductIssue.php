<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductIssue extends Model
{
    protected $fillable = [
       
        'product_id',
        'company_id',
        'title',
        'sub_title',
        'description',
        'code',
        'created_by_id',
        'is_active',
        'is_deleted',
        
    ];

    public function product()
    {
      return $this->belongsTo(Product::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}