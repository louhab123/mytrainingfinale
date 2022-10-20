<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Agent;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;


class AuthController extends Controller
{
    public function login(Request $request){
           
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = request(['email', 'password']);

        if(!Auth::guard('web')->attempt($credentials)) return response()->json(['message' => 'incorrect']); //status removed response()->json(['message' => 'incorrect'], 401);

        else $user = $request->user('web');
        $token = $user->createToken('Personal Access Token');
        $user_role = $user->getRoleNames()[0];
        $token->expires_at = Carbon::now()->addWeeks(1);
        $permissions = [];
      
        foreach( $user->getAllPermissions() as $permission) {
            $permissions[] = $permission->name ;
        }
      
            return response()->json([
                'message' => 'authorized',
                'user' => ['id' => $user->id, 'email' => $user->email, 'name' => $user->nom.' '.$user->prenom,'role' => $user_role],
                'ability' => $permissions,
                'token_type' => 'Bearer',
                'access_token' => $token,
                'expires_at' => Carbon::parse(
                    $token->expires_at
                )->toDateTimeString()
            ]);
        
     
    }
    public function logout(Request $request){
   
        $user = Auth::user();
     
        $user->currentAccessToken()->delete();
        return response([
            'sucess'=>true
        ]);
    }
}

