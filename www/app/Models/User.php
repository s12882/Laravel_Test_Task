<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{

   use HasRoles;
    protected $fillable = [
        'login',
        'first_name',
        'surname',
        'email',
        'phoneNumber',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
      'created_at',
      'updated_at'
    ];

    protected $casts = [
      'login' => 'string',
      'first_name' => 'string',
      'surname' => 'string',
      'email' => 'string',
      'phoneNumber' => 'string',
      'password' => 'string',
      'created_by' => 'integer',
      'updated_by' => 'integer',
    ];

    public function fullName(){
      return $this->first_name . " " . $this->surname;
    }

}
