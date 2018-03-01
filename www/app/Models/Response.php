<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{

    protected $fillable = [
        'name',
        'email',
        'description',    
        'author_id',
    ];

    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'description' => 'string',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
      
    public function getCreatedAtAttribute($date)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }
    
    public function author(){
        return $this->belongsTo('App\Models\User');
    }
}