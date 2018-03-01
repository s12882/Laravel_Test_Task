<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{

    protected $fillable = [
        'name',
        'description',    
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
   
    public function images() {
        return $this->hasMany('App\Models\NewsImage');
    }
    
    public function getCreatedAtAttribute($date)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }
}