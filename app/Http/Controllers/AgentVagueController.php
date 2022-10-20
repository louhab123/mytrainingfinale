<?php

namespace App\Http\Controllers;

use App\Models\AgentVague;
use App\Models\Vague;
use App\Models\FormationFc;
use App\Models\FormationFi;
use App\Models\AgentStateOfPresence;
use Illuminate\Http\Request;

class AgentVagueController extends Controller
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
     * @param  \App\Models\AgentVague  $agentVague
     * @return \Illuminate\Http\Response
     */
    public function show(AgentVague $agentVague)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AgentVague  $agentVague
     * @return \Illuminate\Http\Response
     */
    public function edit(AgentVague $agentVague)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AgentVague  $agentVague
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AgentVague $agentVague)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AgentVague  $agentVague
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgentVague $agentVague)
    {
        //
    }
    public function effectiveByWeeek(){
        $startDate = date("Y-m-d", strtotime('monday this week'));  
        $endDate = date("Y-m-d", strtotime('sunday  this week')); 
        $AgentVague = AgentVague::whereBetween('created_at',[$startDate." 00:00:00",$endDate." 23:59:59"])->get();
        $vague=Vague::whereBetween('created_at',[$startDate." 00:00:00",$endDate." 23:59:59"])->get();
        $FormationFc = FormationFc::whereBetween('created_at',[$startDate." 00:00:00",$endDate." 23:59:59"])->get();
        $FormationFi = FormationFi::whereBetween('created_at',[$startDate." 00:00:00",$endDate." 23:59:59"])->get();
        

         // realiseés
         $FormationFcR = FormationFc::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('dateFin', '=<', date("Y-m-d"))->get();
         $FormationFiR = FormationFi::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('dateFin' , '=<', date("Y-m-d"))->get();
        
         // en cours 
         $FormationFcE = FormationFc::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('dateFin','>=', date("Y-m-d"))->get();
         $FormationFiE = FormationFi::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('dateFin', '>=', date("Y-m-d"))->get();
        
         //Abandons 
         $agentsState = AgentStateOfPresence::whereBetween('created_at',[$startDate." 00:00:00",$endDate." 23:59:59"])->get();
         $agentsGroupByState = $agentsState->groupBy( function ($state) {
          return $state->etat;
         });
         if(isset($agentsGroupByState['Abandon']) && count($agentsGroupByState['Abandon'])>0)$agentsAbandon = count($agentsGroupByState['Abandon']);
         else $agentsAbandon =0;
         $formationsRI = count($FormationFi)!=0 ? round( ((count($FormationFiR))/(count($FormationFi)))*100 ,0): 0;
         $formationsRC = count($FormationFc)!=0 ?round(((count($FormationFcR))/(count($FormationFc)))*100,0) : 0;
         $formationsEC = count($FormationFc)!=0 ? round( ((count($FormationFcE))/(count($FormationFc)))*100,0) : 0;
         $formationsEI = count($FormationFi)!=0  ?round(((count($FormationFiE))/(count($FormationFi)))*100,0) : 0;
         $agentsAbandonRa =count($FormationFc)!=0 ? (($agentsAbandon/(count($FormationFc))))*100 : 0;

        return [
          'effective'=>count($AgentVague),
          'countVague'=>count($vague),
          'countFc'=>count($FormationFc),
          'countFi'=>count($FormationFi),
          'countFiR'=>$formationsRI,
          'countFiE'=>$formationsEI,
          'countFcR'=>$formationsRC,
          'countFcE'=>$formationsEC,
          'abondonsFi'=>$agentsAbandonRa,
        ];
    }
}
