<?php

namespace App\Http\Controllers;
use App\Models\Vague;
use App\Models\Agent;
use App\Models\FormationFi;
use App\Models\FormationFc;
use Illuminate\Http\Request;
use App\Models\Activite ;
use App\Models\Service ;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\AgentVague;

class FormationFiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
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
        $formationFi = new FormationFi();
        $formationFi->nom ='MY-'.$request->site.'-FI-'.substr(Activite ::find($request->actviteId)->nom, 0, 3);
        $formationFi->activite_id  = $request->actviteId;
        $formationFi->service_id  = $request->serviceId ;
        $formationFi->user_id =$user->id;
        $formationFi->statu = 'Noncloturée';
        $formationFi->dateDebut = $request->dateDebut;
        $formationFi->dateFin = $request->dateFin;
        $formationFi->site = $request->site;
        $formationFi->created_at =  Carbon::now()->format('Y-m-d 00:00:00');
        $formationFi->save();
        // vague
        $newVague= new Vague();
        $newVague->nom = 'MY-'.$request->site.'-FI-'.substr(Activite ::find($request->actviteId)->nom, 0, 3);
        $newVague->formation_id =$formationFi->id;
        $newVague->formation_type = 'fi';
        $newVague->site =  $request->site;
        $newVague->activite()->associate($request->actviteId);
        $newVague->service()->associate($request->serviceId);
        $newVague->save();
        // 

    
        return response()->json([
        'wave_id'=>$newVague->id,
        'service_id'=>$request->serviceId,
        ]);
   
    
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FormationFi  $formationFi
     * @return \Illuminate\Http\Response
     */
    public function show(FormationFi $formationFi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FormationFi  $formationFi
     * @return \Illuminate\Http\Response
     */
    public function edit(FormationFi $formationFi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FormationFi  $formationFi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormationFi $formationFi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FormationFi  $formationFi
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormationFi $formationFi)
    {
        //
    }
    public function count(){
        $FormationFc = FormationFi::all();
        return count($FormationFc);
    }
    public function getmyformationsAll(){
        $user = Auth::user();
        $formationfc = FormationFc::where('user_id',$user->id)->get();
        $formationfi = FormationFi::where('user_id',$user->id)->get();
        $data = [];
        if ($formationfc->count() !==0){
            foreach($formationfc as $fc){
             
                $data[]=[
                    'id'=> $fc->id,
                    'nom'=>$fc->nom.' date de début : '. $fc->dateDebut,
                    'activite'=>$fc->activite->id,
                    'service'=>$fc->service->id,
                    'type'=>'fc',
                    'formation'=>$fc,
                ];
            }
        }
      if($formationfi->count() !==0){
        foreach($formationfi as $fi){

            $data[]=[
                'id'=> $fi->id,
                'nom'=>$fi->nom .$fi->nom.' date de début : '. $fi->dateDebut,
                'activite'=>$fi->activite->id,
                'service'=>$fi->service->id,
                'type'=>'fi',
                'formation'=>$fi
            ];
        
        }
      }
            
        if(count($data)==0) return 'nodatafound';
        return response()->json($data);   
    }
    public function deleteMyformation(Request $request){
    
        $user= Auth::user();
        AgentVague::where('vague_id',$request->id)->delete();
     if(Vague::find($request->id)){
        Vague::find($request->id)->delete();
     }
    
     if($request->formation_type=="fi"){
        FormationFi::find($request->formation_id)->delete();
     }
     else if($request->formation_type=="fc")
     FormationFc::find($request->formation_id)->delete();
    }
}
