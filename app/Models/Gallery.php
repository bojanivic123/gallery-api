<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    // protected $fillable = ["name", "description", "urls", "user_id"];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class); 
    } 

    public static function scopeSearchByName($query, $name) {
        return $query->where("name", 'like', '%' . $name . '%')
            ->orWhere("description", 'like', '%' . $name . '%')
            ->orWhereHas("user", function ($query) use ($name) {
                $query->where("first_name", 'like', '%' . $name . '%');
        }); 
    } 
}

