<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_one'
        'user_two'
    ];

    public function messages()
    {
        return $this->hasMany(ChatMessages::class);
    }
    
}
