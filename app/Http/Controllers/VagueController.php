<?php

namespace App\Http\Controllers;

use App\Models\Vague;
use App\Models\AgentVague;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Http\Request;

class VagueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {   
        $vague_agent = AgentVague::where('vague_id',$id)->get();
        
        $vague = Vague::find($id);
        foreach($vague_agent as $agent){
            $data[]=[
                'agent_id'=>$agent->agent_id,
                'agent'=>User::find($agent->agent_id)->nom.' '.User::find($agent->agent_id)->prenom,
                'etat'=> '',
                'formation_id'=>$vague->formation_id,
                'formation_type'=>$vague->formation_type, 
                'startTime'=>'',
                'endTime'=>'',
            ];
        }
        return [
            'agents'=>$data,
            'service_id'=>$vague->service_id,
        ];
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
     * @param  \App\Models\Vague  $vague
     * @return \Illuminate\Http\Response
     */
    public function show(Vague $vague)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vague  $vague
     * @return \Illuminate\Http\Response
     */
    public function edit(Vague $vague)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vague  $vague
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vague $vague)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vague  $vague
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vague $vague)
    {
        //
    }
    public function count(){
        $vagues = Vague::all();
        return count($vagues);
    }
    public function counteffitive(){
        $vague_agents = AgentVague::all();
        return count($vague_agents);
    }
    public function getAll(){
        $vague_agents = AgentVague::all();
        $data= [];
        foreach($vague_agents as $key=> $vague_agent){
            $data[]=[
                'id'=>$vague_agent->vague->id,
                'vague'=>$vague_agent->vague->nom,
                'service'=>$vague_agent->vague->service_id,
                'activite'=>$vague_agent->vague->activite_id,
            ];
        
        }
        return $this->my_array_unique( $data) ;
    }
    function my_array_unique($array, $keep_key_assoc = false){
        $duplicate_keys = array();
        $tmp = array();       
        foreach ($array as $key => $val){
            if (is_object($val))
                $val = (array)$val;
            if (!in_array($val, $tmp))
                $tmp[] = $val;
            else
                $duplicate_keys[] = $key;
        }
        foreach ($duplicate_keys as $key)
            unset($array[$key]);
        return $keep_key_assoc ? $array : array_values($array);
    }
}
