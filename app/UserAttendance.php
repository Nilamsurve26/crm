<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAttendance extends Model
{
    protected $fillable = [
      'company_id',
      'user_id',
      'latitude',
      'longitude',
      'date',
      'ticket_id',
    ];
    public function company()
    {
      return $this->belongsTo(Company::class);
    }
    public function user()
    {
      return $this->belongsTo(User::class);
    }
    
    public function ticket()
    {
      return $this->belongsTo(Ticket::class);
    }
   
  }