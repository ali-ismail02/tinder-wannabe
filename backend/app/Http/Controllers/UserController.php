<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Favorite;
use App\Models\Block;


class UserController extends Controller
{
    public function addOrRemoveFavorite(Request $request){
        if($fav = Favorite::where('favoriter',$request['userData']['id'])->where('favorited',$request['id'])->first()){
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

    public function addOrRemoveBlock(Request $request){
        if($blck = Block::where('blocker',$request['userData']['id'])->where('blocked',$request['id'])->first()){
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
        $user = User::where('gender',$request['userData']['pref'])->where('pref',$request['userData']['gender'])->whereNotIn('id',$blck1)->whereNotIn('id',$blck2)->orderBy('location',"ASC")->get();
        return response()->json([
            "status" => $user
        ]);
    }

    public function searchUsers(Request $request){
        $blck1 = Block::where('blocked',$request['userData']['id'])->get("blocker");
        $blck2 = Block::where('blocker',$request['userData']['id'])->get("blocked");
        $user = User::where('name', 'like', '%' . $request['search'] . '%')->where('gender',$request['userData']['pref'])->where('pref',$request['userData']['gender'])->whereNotIn('id',$blck1)->whereNotIn('id',$blck2)->orderBy('location',"ASC")->get();
        return response()->json([
            "status" => $user
        ]);
    }

}
