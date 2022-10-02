<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    public function favorites() {
        return $this->belongsToMany('User', 'favorites', 'favoriter', 'favorited');
      }
}
