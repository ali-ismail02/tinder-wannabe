<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['user1','user2'];
    public function chats() {
        return $this->belongsToMany('User', 'chats', 'user1', 'user2');
      }

      public function message(){
        return $this->hasMany(Message::class);
    }
}
