<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Favorite;
use App\Models\Block;
use App\Models\Message;
use App\Models\Chat;



class UserController extends Controller
{
    public function addOrRemoveFavorite(Request $request){
        if($fav = Favorite::where('favoriter',$request['userData']['id'])
                        ->where('favorited',$request['id'])
                        ->first()){
            $fav->delete();
            return response()->json([
                "status" => "deleted"
            ]);
        }
        $fav = Favorite::create([
            'favoriter' => $request['userData']['id'],
            'favorited' => $request['id'],
        ]);
        return response()->json([
            "status" => "added"
        ]);
    }

    public function favorites(Request $request){
        $blck1 = Block::where('blocked',$request['userData']['id'])->get("blocker");
        $blck2 = Block::where('blocker',$request['userData']['id'])->get("blocked");
        Favorite::where('favoriter',$request['userData']['id'])
                ->whereNotIn('favorited',$blck1)
                ->whereNotIn('favorited',$blck2)
                ->get();
            return response()->json([
                "status" => "deleted"
            ]);
        $fav = Favorite::create([
            'favoriter' => $request['userData']['id'],
            'favorited' => $request['id'],
        ]);
        return response()->json([
            "status" => "added"
        ]);
    }

    public function addOrRemoveBlock(Request $request){
        if($blck = Block::where('blocker',$request['userData']['id'])
                        ->where('blocked',$request['id'])
                        ->first()){
            $blck->delete();
            return response()->json([
                "status" => "deleted"
            ]);
        }
        $blck = Block::create([
            'blocker' => $request['userData']['id'],
            'blocked' => $request['id'],
        ]);
        return response()->json([
            "status" => "added"
        ]);
    }

    public function displayUsers(Request $request){
        $blck1 = Block::where('blocked',$request['userData']['id'])->get("blocker");
        $blck2 = Block::where('blocker',$request['userData']['id'])->get("blocked");
        $user = User::where('gender',$request['userData']['pref'])
                    ->where('pref',$request['userData']['gender'])
                    ->where('id','!=',$request['userData']['id'])
                    ->whereNotIn('id',$blck1)
                    ->whereNotIn('id',$blck2)
                    ->orderBy('location',"ASC")
                    ->get();
        return response()->json([
            "status" => $user
        ]);
    }

    public function searchUsers(Request $request){
        $blck1 = Block::where('blocked',$request['userData']['id'])->get("blocker");
        $blck2 = Block::where('blocker',$request['userData']['id'])->get("blocked");
        $user = User::where('name', 'like', '%' . $request['search'] . '%')
                    ->where('gender',$request['userData']['pref'])
                    ->where('pref',$request['userData']['gender'])
                    ->where('id','!=',$request['userData']['id'])
                    ->whereNotIn('id',$blck1)
                    ->whereNotIn('id',$blck2)
                    ->orderBy('location',"ASC")
                    ->get();
        return response()->json([
            "status" => 1,
            "message" => $user
        ]);
    }

    public function chats(Request $request){
        $blck1 = Block::where('blocked',$request['userData']['id'])->get("blocker");
        $blck2 = Block::where('blocker',$request['userData']['id'])->get("blocked");
        $chats = DB::table('chats')
                    ->leftJoin("users",'chats.user2', "=", 'users.id')
                    ->where('chats.user1',$request['userData']['id'])
                    ->whereNotIn('chats.user2',$blck1)
                    ->whereNotIn('chats.user2',$blck2)
                    ->get();
        return response()->json([
            "status" => 1,
            "message" => $chats
        ]);
    }

    public function chatAddorOpen(Request $request){
        if(!$chat = Chat::where('user1',$request['userData']['id'])
                        ->where('user2',$request['id'])
                        ->first()){
            $chat = Chat::create([
                'user1' => $request['userData']['id'],
                'user2' => $request['id'],
            ]);
        }
        $messages = Message::where('chat_id',$chat['id'])->orderBy('created_at',"DESC")->get();
        return response()->json([
            "status" => 1,
            "message" => $messages
        ]);
    }

}
