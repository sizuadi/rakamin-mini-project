<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Chat;
use App\Models\ChatMessage;
class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $chat = Chat::where('user_one', $request->user()->id)
                        ->orWhere('user_two', $request->user()->id);

            if ($request->has('key') && $request->key != 'null') {
                $chat->where(function ($query) use ($request) {
                    $query->orWhereRaw("lower(chats.id) like '%" . strtolower($request->key) . "%'");
                });
            }
            
            if ($request->has('id') && is_numeric($request->id)) {
                $chat      = Chat::findOrFail($request->id);

                ChatMessage::where('chat_id', $request->id)
                            ->where('user_id', '!=' ,$request->user()->id)
                            ->update(['read_status' => 1]);

                $chat = ChatMessage::with('user')
                                    ->where('chat_id', $request->id)
                                    ->orderBy('created_at', 'DESC');
            }

            $total = $chat->count();

            if ($request->has('limit') && is_numeric($request->limit)){
                $chat = $chat->paginate(($request->limit == 0 ? $total : $request->limit));
            } else {
                $chat = $chat->get();
                $chat = $chat->sortBy(function($chat){
                            return $chat->col_user;
                        });
            }

            $return = [
                "rows"      => $chat,
                "total"     => $total
            ];

            return successResp("", $return);
        } catch (\Exception $e) {
            return errorResp($e->getMessage(), 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            if($request->user_id == $request->user()->id){
                DB::rollback();
                return errorResp("Cannot chat yourself!", 422);
            }
            $checkChatData1 = Chat::where('user_one', $request->user()->id)
                            ->where('user_two', $request->user_id)->first();
            $checkChatData2 = Chat::where('user_two', $request->user()->id)
                            ->where('user_one', $request->user_id)->first();

            if($checkChatData1){
                $chatId = $checkChatData1->id;
            }elseif($checkChatData2){
                $chatId = $checkChatData2->id;
            }elseif(!$checkChatData1 && !$checkChatData2){
                $chat = New Chat();
                $chat->user_one = $request->user()->id;
                $chat->user_two = $request->user_id;
                $chat->save();

                if(!$chat){
                    DB::rollback();
                    return errorResp("Data failed to save!", 422);
                }

                $chatId = $chat->id;
            }

            $chatMessage = New ChatMessage();
            $chatMessage->user_id  =   $request->user()->id;
            $chatMessage->chat_id  =   $chatId;
            $chatMessage->reply_id =   $request->reply_id;
            $chatMessage->messages =   $request->messages;

            $chatMessage->save();

            if($chatMessage){
                $chat = Chat::find($chatId);
                $chat->updated_at = $chatMessage->created_at;
                $chat->update();

                DB::commit();

                return successResp("Successfully save data", $chat);
            }else{
                DB::rollback();
                return errorResp("Data failed to save!", 422);
            }
            
        } catch (Exception $e) {
            return errorResp($e->getMessage(), 422);
        }
    }
}
