<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
   
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|string|email',
            'password' => 'required|string',
            'role' => "required",
        ]);
        $user = new User();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        $role = Role::where('name', $request->input('role') )->first();
        $user->assignRole($role);
        if(!is_null($request->actviteId))
        

             {
                 $user->activite()->sync($request->actviteId) ;
            }
        
        $user->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();                                                                                                                                                                                             
        // $user->activite ;
        $currentUser = ['id'=>$user->id ,'nom'=>$user->nom,'prenom'=>$user->prenom, 'email'=>$user->email,'actviteId'=> (count($user->activite )>0)? $user->activite[0]->id : '' ,'role'=>$user->getRoleNames()[0], 'password'=>'password'];
        return ['user'=>$currentUser];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $user = User::find($request->id);
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
    public function getFormateurs(){
        $users = User::whereHas("roles", function($q){ $q->where("name", "formateur"); })->get();
        return $users;
    }
    public function getadmins(){
        $users = User::whereHas("roles", function($q){ $q->where("name", "admin"); })->get();
        return $users;
    }
    public function getClients(){
        $users = User::whereHas("roles", function($q){ $q->where("name", "client"); })->get();
        return $users;
    }
}
