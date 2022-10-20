<?php

namespace App\Http\Controllers;

use App\Models\AgentStateOfPresence;
use App\Models\AgentStateOfPresenceDetails;
use App\Models\Agent;
use Illuminate\Http\Request;
use DateTime ;

class AgentStateOfPresenceController extends Controller
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
        
         
      
        $agentsList = $request->agentsList;
          foreach($agentsList as $agent){
            $date1 = new DateTime($agent['startTime']);
            $date2 = new DateTime($agent['endTime']);
            $diff = $date2->diff($date1); 
            $AgentStateOfPresenceFound = AgentStateOfPresence::where('agent_id',$agent['agent_id'])->where('formation_id',$agent['formation_id'])->where('formation_type',$agent['formation_type'])->first();
            if($AgentStateOfPresenceFound== null) {
                // cumule :
                $AgentStateOfPresence = new AgentStateOfPresence();
                $AgentStateOfPresence->agent = $agent['agent'];
                $AgentStateOfPresence->formation_id = $agent['formation_id'];
                $AgentStateOfPresence->formation_type = $agent['formation_type'];
                $AgentStateOfPresence->agent_id = $agent['agent_id'];
                $AgentStateOfPresence->etat = $agent['etat'];
                $AgentStateOfPresence->site = $request->site;
                if(isset($agent['startTime']) && isset($agent['endTime'])) {
                    if($request->pauseDej === true) {
                        $AgentStateOfPresence->cumul  +=  ($diff->h - 1) +($diff->i/60)  ;
                    }
                    else {
                        $AgentStateOfPresence->cumul  +=  $diff->h + ($diff->i/60) ;
                    }
                
                }
                else {
                $AgentStateOfPresence->cumul  +=  0 ;
                } 
                $AgentStateOfPresence->save();
                // details : 
                $AgentStateOfPresenceDetails= new AgentStateOfPresenceDetails();
                $AgentStateOfPresenceDetails->agent = $agent['agent'];
                $AgentStateOfPresenceDetails->agent_id = $agent['agent_id'];
                $AgentStateOfPresenceDetails->formation_id = $agent['formation_id'];
                $AgentStateOfPresenceDetails->formation_type = $agent['formation_type'];
                $AgentStateOfPresenceDetails->etat = $agent['etat'];
                $AgentStateOfPresenceDetails->startTime = date("H:i",strtotime($agent['startTime']));
                $AgentStateOfPresenceDetails->endTime = date("H:i", strtotime( $agent['endTime']));
                $AgentStateOfPresenceDetails->date = $request->date;
                $AgentStateOfPresenceDetails->save();

            }
            else {
                // cumule : 
                if(isset($agent['startTime']) && isset($agent['endTime'])) {
                    if($request->pauseDej === true)
                    {
                        $AgentStateOfPresenceFound->cumul  +=  ($diff->h  - 1) + ($diff->i/60)  ;
                    }
                    else {
                        $AgentStateOfPresenceFound->cumul  +=  $diff->h + ($diff->i/60)  ;
                    }
                
                }
                else {
                    $AgentStateOfPresenceFound->cumul  +=  0 ;
                } 
                $AgentStateOfPresenceFound->save();
                // détail : 
                $AgentStateOfPresenceDetails= new AgentStateOfPresenceDetails();
                $AgentStateOfPresenceDetails->agent = $agent['agent'];
                $AgentStateOfPresenceDetails->agent_id = $agent['agent_id'];
                $AgentStateOfPresenceDetails->formation_id = $agent['formation_id'];
                $AgentStateOfPresenceDetails->formation_type = $agent['formation_type'];
                $AgentStateOfPresenceDetails->etat = $agent['etat'];
                $AgentStateOfPresenceDetails->startTime =date("H:i",strtotime($agent['startTime']));
                $AgentStateOfPresenceDetails->endTime = date("H:i", strtotime( $agent['endTime']));
                $AgentStateOfPresenceDetails->date = $request->date;
                $AgentStateOfPresenceDetails->save();

            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AgentStateOfPresence  $agentStateOfPresence
     * @return \Illuminate\Http\Response
     */
    public function show(Request $req)
    {
       
        $AgentStateOfPresence = AgentStateOfPresence::where('formation_type',$req->formation_type)->where('formation_id',$req->formation_id)->get();
       
        foreach($AgentStateOfPresence as $agent){
            $data[]=[
                'agent_id'=>$agent->agent_id,
                'agent'=>$agent->agent,
                'cumule'=>$agent->cumul,
            ];
        }
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AgentStateOfPresence  $agentStateOfPresence
     * @return \Illuminate\Http\Response
     */
    public function edit(AgentStateOfPresence $agentStateOfPresence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AgentStateOfPresence  $agentStateOfPresence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AgentStateOfPresence $agentStateOfPresence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AgentStateOfPresence  $agentStateOfPresence
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgentStateOfPresence $agentStateOfPresence)
    {
        //
    }
}
