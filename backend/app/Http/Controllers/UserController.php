<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\User;
use app\Models\Favorite;

class UserController extends Controller
{
    public function favorite(Request $request)
    {
        if($fav = Favorite::find($request["id"])){

        }
        return response()->json([
            "status" => $request["id"]
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
