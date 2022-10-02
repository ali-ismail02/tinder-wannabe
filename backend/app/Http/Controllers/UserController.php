<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Favorite;

class UserController extends Controller
{
    public function favorite(Request $request)
    {
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

    function addOrUpdateStore(Request $request, $id = "add"){
        if($id == "add"){
            $store = new Store; 
        }else{
            $store = Store::find($id);
        }

        $store->name = $request->name ? $request->name : $store->name;
        $store->category_id = $request->category_id? $request->category_id : $store->category_id;

        if($store->save()){
            return response()->json([
                "status" => "Success",
                "data" => $store
            ]);
        }

        return response()->json([
            "status" => "Error",
            "data" => "Error creating a model"
        ]);
    }
}
