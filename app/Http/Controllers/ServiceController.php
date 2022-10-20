<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Activite;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services=Service::all();
        return $services;
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
    public function getService($id){
        $service  = Service :: find($id);
        return $service ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service = new Service();
        $service->nom = $request->nom;
        $service->activite_id = $request->activite_id;
        $service->statut = "1";
        $service->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $activite =Activite::find($id);
        return [
            
           'services'=> $activite->services,
           'activitie'=>$activite,
           'image_url'=>($activite->image_url ==null)? '' : asset(\Storage::url($activite->image_url)),
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)

    {
        $service = Service ::find($request->id)  ;
        if($service->statut == 1) {
            $service->statut = 0;
            $service->save();
        }
        if($service->statut == 0) {
            $service->statut = 1;
            $service->save();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        //
    }
    public function editName(Request $request){
        $service = Service::find($request->service_id);
        $service->nom = $request->nom ;
        $service->save();
    }
}
