<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_one',
        'user_two'
    ];

    protected $hidden = [
        'messages', 
        'user_one_info',
        'user_two_info',
    ];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function user_one_info()
    {
        return $this->belongsTo(User::class, 'user_one', 'id');
    }

    public function user_two_info()
    {
        return $this->belongsTo(User::class, 'user_two', 'id');
    }

    protected $appends = [
        'col_unread_numbers',
        'col_last_message',
        'col_last_message_time',
        'col_user'
    ];

    public function getColUnreadNumbersAttribute()
    {
        $unReadNumber = $this->messages->where('read_status', 0)
                                        ->where('user_id', '!=', request()->user()->id)
                                        ->count();

        return $unReadNumber;
    }

    public function getColUserAttribute()
    {
        if(request()->user()->id == $this->user_one_info->id){
            return $this->user_two_info->name;
        }
        return $this->user_one_info->name;
    }

    public function getColLastMessageAttribute()
    {
        $lastMessage = $this->messages
                            ->where('chat_id', $this->id)
                            ->last()
                            ->messages;

        return $lastMessage;
    }

    public function getColLastMessageTimeAttribute()
    {
        $lastMessageTime = $this->messages
                                ->where('chat_id', $this->id)
                                ->last()
                                ->created_at;

        return $lastMessageTime;
    }
    
}
