<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;

    protected $fillable = ['blocker','blocked'];
    public function blocks() {
        return $this->belongsToMany('User', 'blockers', 'blocker', 'blocked');
      }
}
