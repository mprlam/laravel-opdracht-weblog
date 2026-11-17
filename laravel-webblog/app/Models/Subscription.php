<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsToMany(User::class);
    }
    public function article(){
        return $this->belongsToMany(Article::class);
    }

    protected $fillable = ['user_id', 'article_id'];
}
