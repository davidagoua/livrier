<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Requests\LivraisonRequest;
use App\Models\Itineraie;
use App\Models\Livraison;
use App\Models\Localite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function register_client(Request $request)
    {

        $validator = Validator::make($request->input(), [
            'name'=>'required',
            'email'=>'email',
            'phone'=>'required',
            'password'=>'required',
            'device_name'=>'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'success'=>false,
                'data'=>[
                    'error'=> $validator->errors()
                ]
            ]);
        }


        $newClient = new User($validator->getData());
        $newClient->assignRole('client');

        $newClient->save();
        $token =  $newClient->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'success'=>True,
            'data'=>[
                'token'=>$token
            ]
        ]);
    }

    public function new_command(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'origine_id'=>'required',
            'destination_id'=>'required',
            'description'=>'present',
            'prix'=>'present'
        ]);

        if($validator->fails()){
            return response()->json([
                'success'=>false,
                'data'=>$validator->errors()
            ], 401);
        }

        $itineraie = Itineraie::query()
                                ->select('id')
                                ->where('origine_id', $request->origine_id)
                                ->where('destination_id', $request->destination_id)
                                ->first();
        if(! $itineraie){
            return response()->json([
                'success'=>false,
                'data'=>"Itineraie non supporté"
            ], 401);
        }

        $livraison = new Livraison($request->input());
        $livraison->itineraie_id = $itineraie->id;
        $livraison->client_id = auth()->id();
        $livraison->save();
        $livraison->setStatus('attente');

        Redis::publish('new-commande', $livraison->toJson());

        return response()->json([
            'success'=>true,
            'data'=> [
                'livraison'=> $livraison
            ]
        ], 200);
    }

    public function localites(Request $request)
    {
        return response()->json([
            'success'=>true,
            "data"=> Localite::query()->select(['id','name'])->get()
        ], 200);
    }
}
