<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsImage extends Model {

    protected $fillable = [
      'news_id',
      'file_name',
      'original_file_name',
      'type',
      'uploaded_by'
    ];
    protected $dates = [
      'created_at',
      'updated_at'
    ];
    protected $casts = [
      'file_name' => 'string',
      'original_file_name' => 'string',
      'type' => 'string',
      'news_id' => 'integer'
    ];
    
    public function fullPath()
    {
        return public_path().'/images/news/'.$this->file_name;
    }
    
    public function webPath()
    {
        return '/images/news/'.$this->file_name;
    }
}