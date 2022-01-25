<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function structure(){
      return $this->belongsTo(Structure::class);
      }
      public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
