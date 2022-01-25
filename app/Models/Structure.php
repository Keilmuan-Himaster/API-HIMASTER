<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function members(){
    return $this->hasMany(Member::class);
    }
    public function moneys(){
      return $this->hasMany(Money::class);
      }

    public function timelines(){
      return $this->hasMany(Timeline::class);
      }
   public function galleries(){
      return $this->hasMany(Gallery::class);
   }


    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
