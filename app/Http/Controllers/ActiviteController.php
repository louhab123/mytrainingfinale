<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActiviteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user= Auth::user();
        $userActivitys = $user->activite;
        if(count( $userActivitys )!= 0){
            return $userActivitys;
        }
        else {
            $activites = Activite::all();
            return $activites;
        }

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
    
        $activite = new Activite();
        $activite->nom = $request->nom;
        $activite->statut = 1;
        $activite->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activite  $activite
     * @return \Illuminate\Http\Response
     */
    public function show(Activite $activite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Activite  $activite
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        
        $activite= Activite::find($request->id);
        if($request->statut === '1') $activite->statut = 0;
        if($request->statut === '0') $activite->statut = 1;
        $activite->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activite  $activite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activite $activite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activite  $activite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activite $activite)
    {
        //
    }
    public function changeActivitieImage(Request $request){
        $activite= Activite::find($request->activitie_id);
        $fileName = $activite->nom.'_'.time().'.'.$request->file->extension();
        $path = $request->file('file')->storeAs('uploads/activities', $fileName, 'public');
        $activite->image_url = $path;
        $activite->save();
        return [
        'image_url'=>asset(\Storage::url($activite->image_url))
    ];
    }
}
