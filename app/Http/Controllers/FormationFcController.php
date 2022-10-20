<?php

namespace App\Http\Controllers;
use App\Models\Vague;
use App\Models\FormationFc;
use App\Models\FormationFi;
use Illuminate\Http\Request;
use App\Models\Activite ;
use App\Models\Service ;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DateTime ;

class FormationFcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll() {
      
        $user = Auth::user();
        $formationfc = FormationFc::all();
        $formationfi = FormationFi::all();
        if ($formationfc->count() !==0){
            foreach($formationfc as $fc){
             
                $data[]=[
                    'id'=> $fc->id,
                    'nom'=>$fc->nom,
                    'activite'=>$fc->activite->nom,
                    'service'=>$fc->service->nom,
                    'user'=>$fc->user->nom. ' '.$fc->user->prenom,
                    'startDate'=>$fc->dateDebut,
                    'endDate'=>$fc->dateFin,
                    'site'=>$fc->site,
                    'statut'=>$fc->dateFin <= date("Y-m-d") ? 'cloturé' : 'non cloturé',
                    'vague'=>Vague::where('formation_id',$fc->id)->first(),
                    'type'=>'formation continue',
                ];
            }
        }
      if($formationfi->count() !==0){
        foreach($formationfi as $fi){

            $data[]=[
                'id'=> $fi->id,
                'nom'=>$fi->nom,
                'activite'=>$fi->activite->nom,
                'service'=>$fi->service->nom,
                'user'=>$fi->user->nom. ' '.$fi->user->prenom,
                'startDate'=>$fi->dateDebut,
                'endDate'=>$fi->dateFin,
                'site'=>$fi->site,
                'statut'=>$fi->dateFin <= date("Y-m-d") ? 'cloturé' : 'non cloturé',
                'vague'=>Vague::where('formation_id',$fi->id)->first(),
                'type'=>'formation initiale',
            ];
        
        }
      }
            
    
        return response()->json($data);
    }
    public function index()
    {   
        $user = Auth::user();
        $formationfc = FormationFc::where('user_id',$user->id)->get();
        $formationfi = FormationFi::where('user_id',$user->id)->get();
        $data = [];
        if ($formationfc->count() !==0){
            foreach($formationfc as $fc){
             
                $data[]=[
                    'id'=> $fc->id,
                    'nom'=>$fc->nom,
                    'activite'=>$fc->activite->nom,
                    'service'=>$fc->service->nom,
                    'user'=>$fc->user->nom. ' '.$fc->user->prenom,
                    'startDate'=>$fc->dateDebut,
                    'endDate'=>$fc->dateFin,
                    'site'=>$fc->site,
                    'statut'=>$fc->dateFin <= date("Y-m-d") ? 'cloturé' : 'non cloturé',
                    'vague'=>Vague::where('formation_id',$fc->id)->first(),
                    'type'=>'formation continue',
                ];
            }
        }
      if($formationfi->count() !==0){
        foreach($formationfi as $fi){

            $data[]=[
                'id'=> $fi->id,
                'nom'=>$fi->nom,
                'activite'=>$fi->activite->nom,
                'service'=>$fi->service->nom,
                'user'=>$fi->user->nom. ' '.$fi->user->prenom,
                'startDate'=>$fi->dateDebut,
                'endDate'=>$fi->dateFin,
                'site'=>$fi->site,
                'statut'=>$fi->dateFin <= date("Y-m-d") ? 'cloturé' : 'non cloturé',
                'vague'=>Vague::where('formation_id',$fi->id)->first(),
                'type'=>'formation initiale',
            ];
        
        }
      }
            
        if(count($data)==0) return 'nodatafound';
        return response()->json($data);
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
        
        $user = Auth::user();
        $formationFc = new FormationFc();
        $formationFc->nom = $request->nom;
        $formationFc->activite_id  = $request->actviteId;
        $formationFc->service_id  = $request->serviceId ;
        $formationFc->user_id =$user->id;
        $formationFc->statu = 'Noncloturée';
        $formationFc->dateDebut = $request->dateDebut;
        $formationFc->site = $request->site;
        $formationFc->dateFin = $request->dateFin;
        $formationFc->created_at =  Carbon::now()->format('Y-m-d 00:00:00');
    

        $formationFc->save();
        $newVague= new Vague();
        $newVague->nom = 'MY-'.$request->site.'-FC-'.substr(Activite ::find($request->actviteId)->nom, 0, 3);
        $newVague->formation_id =$formationFc->id;
        $newVague->site =  $request->site;
        $newVague->activite()->associate($request->actviteId);
        $newVague->service()->associate($request->serviceId);
        $newVague->formation_type = 'fc';

     if(  

     $newVague->save()
)

    {
      

        return response()->json([
        'wave_id'=>$newVague->id
        ]);
    }
    else {
       return 0 ;
    }
   
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FormationFc  $formationFc
     * @return \Illuminate\Http\Response
     */
    public function show(FormationFc $formationFc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FormationFc  $formationFc
     * @return \Illuminate\Http\Response
     */
    public function edit(FormationFc $formationFc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FormationFc  $formationFc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormationFc $formationFc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FormationFc  $formationFc
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormationFc $formationFc)
    {
        //
    }
    public function count(){
        $FormationFc = FormationFc::all();
        return count($FormationFc);
    }
    public function getMyFormations(Request $request){

        $startDate = DateTime::createFromFormat('d/m/Y',$request->startDay)->format('Y-m-d');
        $endDate = DateTime::createFromFormat('d/m/Y', $request->endDay)->format('Y-m-d');
        $user = Auth::user();
        $formationfc = FormationFc::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('user_id',$user->id)->get();
        $formationfi = FormationFi::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('user_id',$user->id)->get();
        $data = [];
        if ($formationfc->count() !==0){
            foreach($formationfc as $fc){
             
                $data[]=[
                    'id'=> $fc->id,
                    'nom'=>$fc->nom,
                    'activite'=>$fc->activite->nom,
                    'service'=>$fc->service->nom,
                    'user'=>$fc->user->nom. ' '.$fc->user->prenom,
                    'startDate'=>$fc->dateDebut,
                    'endDate'=>$fc->dateFin,
                    'site'=>$fc->site,
                    'statut'=>$fc->dateFin <= date("Y-m-d") ? 'cloturé' : 'non cloturé',
                    'vague'=>Vague::where('formation_id',$fc->id)->first(),
                    'type'=>'formation continue',
                ];
            }
        }
      if($formationfi->count() !==0){
        foreach($formationfi as $fi){

            $data[]=[
                'id'=> $fi->id,
                'nom'=>$fi->nom,
                'activite'=>$fi->activite->nom,
                'service'=>$fi->service->nom,
                'user'=>$fi->user->nom. ' '.$fi->user->prenom,
                'startDate'=>$fi->dateDebut,
                'endDate'=>$fi->dateFin,
                'site'=>$fi->site,
                'statut'=>$fi->dateFin <= date("Y-m-d") ? 'cloturé' : 'non cloturé',
                'vague'=>Vague::where('formation_id',$fi->id)->first(),
                'type'=>'formation initiale',
            ];
        
        }
      }
            
        if(count($data)==0) return 'nodatafound';
        return response()->json($data); 
    }
 
}
