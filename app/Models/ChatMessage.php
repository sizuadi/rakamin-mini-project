<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'user_id',
        'reply_id',
        'messages',
        'read_status'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    
    protected $appends = [
        'col_reply'
    ];

    public function getColReplyAttribute()
    {
        return ChatMessage::where('reply_id', $this->reply_id)->first()->messages;
    }
}
