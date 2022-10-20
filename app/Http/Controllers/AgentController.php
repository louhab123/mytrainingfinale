<?php

namespace App\Http\Controllers;


use App\Models\Agent;
use App\Models\User;
use App\Models\FormationFi;
use App\Models\FormationFc;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Models\Vague;
use Illuminate\Support\Facades\Hash;
use App\Models\AgentVague;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        
        $agents=User::whereHas("roles", function($q){ $q->where("name", "agent"); })->get();
        foreach ($agents as $agent){
            $data[] = ['id'=>$agent->id,'nom'=> $agent->nom.' '.$agent->prenom ,'email'=> $agent->email,'service'=> (Agent::where('email',$agent->email)->first() && Agent::where('email',$agent->email)->first()->service) ? Agent::where('email',$agent->email)->first()->service->nom :' ','activite'=>(Agent::where('email',$agent->email)->first()&& Agent::where('email',$agent->email)->first()->service ) ? Agent::where('email',$agent->email)->first()->service->activite->nom : ' ','glutenfree'=>false];
        }
        return $data;
    }
    public function getAllAgentVague()
    {
        $agents = AgentVague::all();
        $data = array();
        foreach ($agents as $agent){
            $data[] = [
                'id'=>$agent->agent_id,
                'agent'=>User::find($agent->agent_id)->nom . ' '.User::find($agent->agent_id)->prenom,
                'vague_id'=>$agent->vague_id
            ];
        }
        return $data;
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
     $agents =$request->agents;
     $waveId= $request->waveId;
     $service_id = $request->service_id;
     foreach($agents as $agent){
        if(Agent::where('email',$agent['email'])->first() || User::where('email',$agent['email'])->first()){
          return 'exit';
        }
        else {
            $NewAgent =new Agent();
            $NewAgent->nom = $agent['nom'];
            $NewAgent->prenom = $agent['prenom'];
            $NewAgent->email =$agent['email'];
            $NewAgent->service_id = $service_id;
            $NewAgent->save();
    
   
           // compte user 
            $user=new User();
            $user->nom = $agent['nom']  ;
            $user->prenom = $agent['prenom'] ;
            $user->email =  $agent['email'];
            $user->password = Hash::make('password');
            $role = Role::where('name','agent')->first();
            $user->assignRole($role);
            $user->save();
            // assigne to vague 
            $agentVague = new AgentVague();
            $agentVague->agent_id= $user->id;
            $agentVague->vague_id= $waveId;
            $agentVague->save();
        }
      
        
        
     }
     return 'added';  
      
    }
    public function store2(Request $request)
    {
        

   
       
        $NewAgent =new Agent();
          
         $NewAgent->nom =  $request->agents['nom'];
         $NewAgent->prenom =  $request->agents['prenom'];
         $NewAgent->email = $request->agents['email'];
         $NewAgent->service_id = $request->agents['service'];
         $NewAgent->save();
         if(   $request->agents['statu']=='Active') {
                $user=new User();
                $user->nom = $request->agents['nom']  ;
                $user->prenom = $request->agents['prenom'] ;
                $user->email =  $request->agents['email'];
                $user->password = Hash::make('password');
                $user->save();

         }
    
         
     
       
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function show(Agent $agent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function edit(Agent $agent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agent $agent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agent $agent)
    {
        //
    }
    public function selectedAgent(Request $request){
        $agents =$request->agents;
        $waveId= $request->waveId;
        foreach($agents as $agent){
            $agentFind = User::find($agent['id']);
            $agentVague = new AgentVague();
            $agentVague->agent_id= $agentFind->id;
            $agentVague->vague_id= $waveId;
            $agentVague->save();
      
        }
    }
    public function count(){
        $Agent=Agent::all();
        return count($Agent);
    }
    public function getAgentdetails($id){
  
    $agent = Agent::find($id) ;
    $fis = FormationFi::where('user_id',$id)->get();
    $fcs = FormationFc::where('user_id',$id)->get();
    $data = [];
    foreach($fis as $fi){
      $data['fis'] = [
        'formation_name'=>$fi->nnom,
        'activitie'=>$fi->activite->nom,
        'service'=>$fi->service->nom
      ];
    }
    foreach($fcs as $fc){
        $data['fcs'] = [
          'formation_name'=>$fc->nnom,
          'activitie'=>$fc->activite->nom,
          'service'=>$fc->service->nom
        ];
      }
    $data['agent']=[
        'agent'=>$agent->nom .' '.$agent->prenom
    ]  ;
    return $data ;
    }
}
