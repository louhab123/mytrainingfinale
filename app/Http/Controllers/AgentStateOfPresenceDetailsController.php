<?php

namespace App\Http\Controllers;

use App\Models\AgentStateOfPresenceDetails;
use Illuminate\Http\Request;

class AgentStateOfPresenceDetailsController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AgentStateOfPresenceDetails  $agentStateOfPresenceDetails
     * @return \Illuminate\Http\Response
     */
    public function show(Request $req)
    {   
      
        $agentStateOfPresenceDetails = AgentStateOfPresenceDetails::where('formation_type',$req->formation_type)->where('formation_id',$req->formation_id)->get();
       
        foreach($agentStateOfPresenceDetails as $agent){
            $data[]=[
                'agent_id'=>$agent->agent_id,
                'agent'=>$agent->agent,
                'etat'=>$agent->etat,
                'date'=>$agent->date,
                'endTime'=>$agent->endTime,
                'startTime'=>$agent->startTime,
            ];
        }
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AgentStateOfPresenceDetails  $agentStateOfPresenceDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(AgentStateOfPresenceDetails $agentStateOfPresenceDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AgentStateOfPresenceDetails  $agentStateOfPresenceDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AgentStateOfPresenceDetails $agentStateOfPresenceDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AgentStateOfPresenceDetails  $agentStateOfPresenceDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgentStateOfPresenceDetails $agentStateOfPresenceDetails)
    {
        //
    }
}
