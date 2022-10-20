<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormationFc;
use App\Models\FormationFi;
use App\Models\AgentVague;
use App\Models\Activite;
use App\Models\Vague;
use App\Models\NoteAgent;
use App\Models\QuizSimpleGroup;
use App\Models\AgentStateOfPresence;
use DateTime ;

class ReportingController extends Controller
{
    //
    public function globaleReporting(Request $request){
      
        $startDate = DateTime::createFromFormat('d/m/Y',$request->startDay)->format('Y-m-d');
        $endDate = DateTime::createFromFormat('d/m/Y', $request->endDay)->format('Y-m-d');
      
        if(isset($request->site[0]) && isset($request->site[1]) && isset($request->site[2]) && isset($request->site[3])){
            $FormationFc = FormationFc::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereIn('site',[$request->site[0],$request->site[1],$request->site[2],$request->site[3]])->get();
            $FormationFi = FormationFi::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereIn('site',[$request->site[0],$request->site[1],$request->site[2],$request->site[3]])->get();
        }
        else  if(isset($request->site[0]) && isset($request->site[1]) && isset($request->site[2]) ){
            $FormationFc = FormationFc::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereIn('site',[$request->site[0],$request->site[1],$request->site[2]])->get();
            $FormationFi = FormationFi::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereIn('site',[$request->site[0],$request->site[1],$request->site[2]])->get();
        }

        else  if(isset($request->site[0]) && isset($request->site[1]) ){
            $FormationFc = FormationFc::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereIn('site',[$request->site[0],$request->site[1]])->get();
            $FormationFi = FormationFi::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereIn('site',[$request->site[0],$request->site[1]])->get();
        }
        else  if(isset($request->site[0])  ){
            $FormationFc = FormationFc::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('site',$request->site[0])->get();
            $FormationFi = FormationFi::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('site',$request->site[0])->get();
        }
        // realiseés
        if(isset($request->site[0]) && isset($request->site[1]) && isset($request->site[2]) && isset($request->site[3] ) ){
            $FormationFcR = FormationFc::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('dateFin', '<', date("Y-m-d"))->whereIn('site',[$request->site[0],$request->site[1],$request->site[2],$request->site[3]])->get();
            $FormationFiR = FormationFi::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('dateFin', '<', date("Y-m-d"))->whereIn('site',[$request->site[0],$request->site[1],$request->site[2],$request->site[3]])->get();
        }
        else  if(isset($request->site[0]) && isset($request->site[1]) && isset($request->site[2])  ){
            $FormationFcR = FormationFc::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('dateFin', '<', date("Y-m-d"))->whereIn('site',[$request->site[0],$request->site[1],$request->site[2]])->get();
            $FormationFiR = FormationFi::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('dateFin', '<', date("Y-m-d"))->whereIn('site',[$request->site[0],$request->site[1],$request->site[2]])->get();
        }
        else  if(isset($request->site[0]) && isset($request->site[1]) ){
            $FormationFcR = FormationFc::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('dateFin', '<', date("Y-m-d"))->whereIn('site',[$request->site[0],$request->site[1]])->get();
            $FormationFiR = FormationFi::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('dateFin', '<', date("Y-m-d"))->whereIn('site',[$request->site[0],$request->site[1]])->get();
        }
        else  if(isset($request->site[0]) ){
            $FormationFcR = FormationFc::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('dateFin', '<', date("Y-m-d"))->where('site',$request->site[0])->get();
            $FormationFiR = FormationFi::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('dateFin', '<', date("Y-m-d"))->where('site',$request->site[0])->get();
        }
        // en cours 
        if(isset($request->site[0]) && isset($request->site[1]) && isset($request->site[2]) && isset($request->site[3]) ){
            $FormationFcE = FormationFc::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('dateFin','>=', date("Y-m-d"))->whereIn('site',[$request->site[0],$request->site[1],$request->site[2],$request->site[3]])->get();
            $FormationFiE = FormationFi::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('dateFin','>=', date("Y-m-d"))->whereIn('site',[$request->site[0],$request->site[1],$request->site[2],$request->site[3]])->get();
        }
        else if(isset($request->site[0]) && isset($request->site[1]) && isset($request->site[2])  ){
            $FormationFcE = FormationFc::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('dateFin','>=', date("Y-m-d"))->whereIn('site',[$request->site[0],$request->site[1],$request->site[2]])->get();
            $FormationFiE = FormationFi::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('dateFin','>=', date("Y-m-d"))->whereIn('site',[$request->site[0],$request->site[1],$request->site[2]])->get();
        }
        else if(isset($request->site[0]) && isset($request->site[1])  ){
            $FormationFcE = FormationFc::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('dateFin','>=', date("Y-m-d"))->whereIn('site',[$request->site[0],$request->site[1]])->get();
            $FormationFiE = FormationFi::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('dateFin','>=', date("Y-m-d"))->whereIn('site',[$request->site[0],$request->site[1]])->get();
        }
        else if(isset($request->site[0])  ){
            $FormationFcE = FormationFc::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('dateFin','>=', date("Y-m-d"))->where('site',$request->site[0])->get();
            $FormationFiE = FormationFi::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('dateFin','>=', date("Y-m-d"))->where('site',$request->site[0])->get();
        }
        //Abandons 
        if(isset($request->site[0]) && isset($request->site[1]) && isset($request->site[2]) && isset($request->site[3]) ){
            $agentsState = AgentStateOfPresence::whereBetween('created_at',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereIn('site',[$request->site[0],$request->site[1],$request->site[2],$request->site[3]])->get();
        }
        else  if(isset($request->site[0]) && isset($request->site[1]) && isset($request->site[2])  ){
            $agentsState = AgentStateOfPresence::whereBetween('created_at',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereIn('site',[$request->site[0],$request->site[1],$request->site[2]])->get();
        }
        else  if(isset($request->site[0]) && isset($request->site[1]) ){
            $agentsState = AgentStateOfPresence::whereBetween('created_at',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereIn('site',[$request->site[0],$request->site[1]])->get();
        }
        else  if(isset($request->site[0])  ){
            $agentsState = AgentStateOfPresence::whereBetween('created_at',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('site',$request->site[0])->get();
        }

        $agentsGroupByState = $agentsState->groupBy( function ($state) {
         return $state->etat;
        });
        if(count($agentsState)>0 && isset($agentsGroupByState['Abandon']))$agentsAbandon = count($agentsGroupByState['Abandon']);
        else $agentsAbandon =0;
        $formationsRI = count($FormationFi)!=0 ? ((count($FormationFiR))/(count($FormationFi)))*100 : 0;
        $formationsRC = count($FormationFc)!=0 ?((count($FormationFcR))/(count($FormationFc)))*100 : 0;
        $formationsEC = count($FormationFc)!=0 ? ((count($FormationFcE))/(count($FormationFc)))*100 : 0;
        $formationsEI = count($FormationFi)!=0  ?((count($FormationFiE))/(count($FormationFi)))*100 : 0;
        $agentsAbandonRa =count($FormationFc)!=0 ? (($agentsAbandon/(count($FormationFc))))*100 : 0;
        // by formateur 
        $groupByUserFI = $FormationFi->groupBy( function ($formation) {
            return $formation->user->nom .' ' .$formation->user->prenom;
        });
        $groupByUserFi_nbr = $groupByUserFI->map(function ($item, $key) {
            return collect($item)->count();
        });
        $groupByUserFC = $FormationFc->groupBy( function ($formation) {
            return $formation->user->nom.' '.$formation->user->prenom;
        });
        $groupByUserFc_nbr = $groupByUserFC->map(function ($item, $key) {
            return collect($item)->count();
        });
        // by activite 
        $groupByactiviteFC = $FormationFc->groupBy( function ($formation) {
            return $formation->activite->nom;
        });
        $groupByactiviteFi = $FormationFi->groupBy( function ($formation) {
            return $formation->activite->nom;
        });
 
        $groupByactiviteFi_nbr = $groupByactiviteFi->map(function ($item, $key) {
            return collect($item)->count();
        });
        $groupByactiviteFC_nbr = $groupByactiviteFC->map(function ($item, $key) {
            return collect($item)->count();
        });
         return [
             'formationsC'=>count($FormationFc),
             'formationsI'=>count($FormationFi),
             'formationsRI'=>round($formationsRI,2),
             'formationsEI'=>round($formationsEI,2),
             'formationsRC'=>$formationsRC,
             'formationsEC'=>$formationsEC,
             'abandons'=>$agentsAbandonRa,
             'formationIUser'=>$groupByUserFi_nbr,
             'formationCUser'=>$groupByUserFc_nbr,
             'actviteC'=>$groupByactiviteFC_nbr,
             'actviteI'=>$groupByactiviteFi_nbr,
         ];
    }
    public function  byService(){
        $FormationFc = FormationFc::all();
        $FormationFi = FormationFi::all();
        $groupByactiviteFC = $FormationFc->groupBy( function ($formation) {
            return $formation->service->nom;
        });
        $groupByactiviteFi = $FormationFi->groupBy( function ($formation) {
            return $formation->service->nom;
        });
 
        $groupByactiviteFi_nbr = $groupByactiviteFi->map(function ($item, $key) {
            return collect($item)->count();
        });
        $groupByactiviteFC_nbr = $groupByactiviteFC->map(function ($item, $key) {
            return collect($item)->count();
        });
        return [
            'fi'=>$groupByactiviteFi_nbr,
            'fc'=>$groupByactiviteFC_nbr];
    }
    public function getFormationsByActviteAnsService(){
        $FormationFi = FormationFi::all();

        $groupByServiceFi = $FormationFi->groupBy( function ($formation) {
            return $formation->service->nom;
        });
       foreach ($groupByServiceFi as $fiByService){
           
           $children= [ 'id'=>$fiByService[0]->service->id, 'name'=> $fiByService[0]->service->nom.' : '.  count($fiByService) ];
           $data[
            $fiByService[0]->activite->nom
              
              ][]=$children;
       }
       foreach($data as $key=>$d){
        $data2[]=[
            'id'=> Activite::where('nom',$key)->first()->id,
            'name'=>$key,
            'children'=>$data[$key]
        ];
    }
    return $data2;
      
      
    }
    public function getFormationsByActviteAnsService2(){
        $FormationFc = FormationFc::all();
        $groupByServiceFC = $FormationFc->groupBy( function ($formation) {
            return $formation->service->nom;
        });
       foreach ($groupByServiceFC as $fiByService){
           $children= [ 'id'=>$fiByService[0]->service->id, 'name'=> $fiByService[0]->service->nom.' : '.  count($fiByService) ];
           $data[
            $fiByService[0]->activite->nom
              
              ][]=$children; 
       }
       foreach($data as $key=>$d){
        $data2[]=[
            'id'=> Activite::where('nom',$key)->first()->id,
            'name'=>$key,
            'children'=>$data[$key]
        ];
    }
    return $data2;
        
      
      
    }
    public function getQuizSimpleByActvite(){
        $QuizSimpleGroup = QuizSimpleGroup::all();
        $groupByService = $QuizSimpleGroup->groupBy( function ($quiz) {
            return $quiz->service->nom;
        });
    
        foreach ($groupByService as $key=> $quizByService){
            $children= [ 'id'=>$quizByService[0]->service->id, 'name'=> $quizByService[0]->service->nom.' : '.  count($quizByService) ];
            $data[
      $quizByService[0]->activite->nom
        
        ][]=$children; 
        }
      
         foreach($data as $key=>$d){
       
             $data2[]=[
                 'id'=> Activite::where('nom',$key)->first()->id,
                 'name'=>$key,
                 'children'=>$data[$key]
             ];
         }
         return $data2;
    }
    public function getReportingActvity(Request $request){
        $startDate = DateTime::createFromFormat('d/m/Y',$request->startDay)->format('Y-m-d');
        $endDate = DateTime::createFromFormat('d/m/Y', $request->endDay)->format('Y-m-d');
        // vagues 
        $vagues = Vague::whereBetween('created_at',[$startDate,$endDate." 23:59:59"])->where('site',$request->site)->where('activite_id',$request->actviteId)->get();
        // formations 
        $FormationFc = FormationFc::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('activite_id',$request->actviteId)->where('site',$request->site)->get();
        $FormationFi = FormationFi::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('activite_id',$request->actviteId)->where('site',$request->site)->get();
        $i= 0;
        foreach($vagues as $vague){
            $i += count($vague->agents_vagues);
        }
        // quizs : ->where('site',$request->site)
        $quizs = QuizSimpleGroup::whereBetween('created_at',[$startDate."00:00:00",$endDate." 23:59:59"])->where('activite_id',$request->actviteId)->get();
        $countQuiz =count($quizs);
        $countQuizP = 0;
        foreach($quizs as $quiz){
            $countQuizP+= count($quiz->notes);
        }
        
        $groupByUserFI = $FormationFi->groupBy( function ($formation) {
            return $formation->user->nom;
        });
        $groupByUserFi_nbr = $groupByUserFI->map(function ($item, $key) {
            return collect($item)->count();
        });
        $groupByUserFC = $FormationFc->groupBy( function ($formation) {
            return $formation->user->nom;
        });
        $groupByUserFc_nbr = $groupByUserFC->map(function ($item, $key) {
            return collect($item)->count();
        });
        // by service 
        $groupByServiceFC = $FormationFc->groupBy( function ($formation) {
            return $formation->service->nom;
        });
        $groupByServiceFI = $FormationFi->groupBy( function ($formation) {
            return $formation->service->nom;
        });
 
        $groupByServiceFI_nbr = $groupByServiceFI->map(function ($item, $key) {
            return collect($item)->count();
        });
        $groupByServiceFC_nbr = $groupByServiceFC->map(function ($item, $key) {
            return collect($item)->count();
        });
         return [
             'countVague'=>count($vagues),
             'effective'=>$i,
             'countFc'=>count($FormationFc),
             'countFi'=>count($FormationFi),
             'formationIUser'=>$groupByUserFi_nbr,
             'formationCUser'=>$groupByUserFc_nbr,
             'SeriviceI'=>$groupByServiceFI_nbr,
             'SeriviceC'=>$groupByServiceFC_nbr,
             'countQuiz'=>$countQuiz,
             'countQuizP'=>$countQuizP,
         ];
    }
    public function getReportingbySerice(Request $request){
        $startDate = DateTime::createFromFormat('d/m/Y',$request->startDay)->format('Y-m-d');
        $endDate = DateTime::createFromFormat('d/m/Y', $request->endDay)->format('Y-m-d');
        // vagues 
        $vagues = Vague::whereBetween('created_at',[$startDate."00:00:00",$endDate." 23:59:59"])->where('site',$request->site)->where('service_id',$request->serviceId)->get();
        // formations 
        $FormationFc = FormationFc::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('service_id',$request->serviceId)->where('site',$request->site)->get();
        $FormationFi = FormationFi::whereBetween('dateDebut',[$startDate." 00:00:00",$endDate." 23:59:59"])->whereBetween('dateFin',[$startDate." 00:00:00",$endDate." 23:59:59"])->where('service_id',$request->serviceId)->where('site',$request->site)->get();
        $i= 0;
        foreach($vagues as $vague){
            $i += count($vague->agents_vagues);
        }
        // quizs : ->where('site',$request->site)
        $quizs = QuizSimpleGroup::whereBetween('created_at',[$startDate."00:00:00",$endDate." 23:59:59"])->where('service_id',$request->serviceId)->get();
        $countQuiz =count($quizs);
        $countQuizP = 0;
        foreach($quizs as $quiz){
            $countQuizP+= count($quiz->notes);
        }
        
        $groupByUserFI = $FormationFi->groupBy( function ($formation) {
            return $formation->user->nom;
        });
        $groupByUserFi_nbr = $groupByUserFI->map(function ($item, $key) {
            return collect($item)->count();
        });
        $groupByUserFC = $FormationFc->groupBy( function ($formation) {
            return $formation->user->nom;
        });
        $groupByUserFc_nbr = $groupByUserFC->map(function ($item, $key) {
            return collect($item)->count();
        });
        // by service 
        $groupByServiceFC = $FormationFc->groupBy( function ($formation) {
            return $formation->service->nom;
        });
        $groupByServiceFI = $FormationFi->groupBy( function ($formation) {
            return $formation->service->nom;
        });
 
        $groupByServiceFI_nbr = $groupByServiceFI->map(function ($item, $key) {
            return collect($item)->count();
        });
        $groupByServiceFC_nbr = $groupByServiceFC->map(function ($item, $key) {
            return collect($item)->count();
        });
         return [
             'countVague'=>count($vagues),
             'effective'=>$i,
             'countFc'=>count($FormationFc),
             'countFi'=>count($FormationFi),
             'formationIUser'=>$groupByUserFi_nbr,
             'formationCUser'=>$groupByUserFc_nbr,
             'SeriviceI'=>$groupByServiceFI_nbr,
             'SeriviceC'=>$groupByServiceFC_nbr,
             'countQuiz'=>$countQuiz,
             'countQuizP'=>$countQuizP,
         ];
    }
    public function getReportingbyAgent(Request $request){
     
        $startDate = DateTime::createFromFormat('d/m/Y',$request->startDay)->format('Y-m-d');
        $endDate = DateTime::createFromFormat('d/m/Y', $request->endDay)->format('Y-m-d');
        $Agentsvagues = AgentVague::whereBetween('created_at',[$startDate,$endDate." 23:59:59"])->where('agent_id',$request->agentId)->get();
        $noteAgent=NoteAgent::where('agent_id',$request->agentId)->get();
        $vagues = [];
        $notes = [];
        foreach($Agentsvagues as $agentVague){
            $vagues[]=[
                'vague'=>$agentVague->vague->nom,
                'activite'=>$agentVague->vague->activite->nom,
                'service'=>$agentVague->vague->service->nom,
            ];
        }
        foreach($noteAgent as $note){
            $notes[]=[
                   'quiz'=>$note->quizsimplegroup->nom,
                   'service'=>$note->service->nom,
                   'activite'=>$note->activite->nom,
                   'agent_id'=>$note->agent->id,
                   'note'=>$note->note
            ];
        }
        // grooup notes  by service :
        $groupNotesByService =  $noteAgent->groupBy( function ($note) {
            return $note->service->nom;
        });
        $moyenneNoteService = [];
        foreach($groupNotesByService as $key=>$notebyservice){
            $i = 0;
            foreach($notebyservice as $note){
                    $i+=$note->note;
            }
            $moyenneNoteService[$key]=round($i/count($notebyservice),2);
            
        }
    
        $groupNotesByService_nbr = $groupNotesByService->map(function ($item, $key) {
            return collect($item)->count();
        });
        // grooup notes  by activite :
        $moyenneNoteActivite = [];
        $groupNotesByActivite =  $noteAgent->groupBy( function ($note) {
            return $note->activite->nom;
        });
        foreach($groupNotesByActivite as $key=>$noteByActivite){
            $i=0;
            foreach($noteByActivite as $note){
                $i+= $note->note;
            }
            $moyenneNoteActivite[$key]= round($i/count($noteByActivite),2);
        }
 
        $groupNotesByActivite_nbr = $groupNotesByActivite->map(function ($item, $key) {
            return collect($item)->count();
        });
        return [
            'agentVagues'=>$vagues,
            'agentNotes'=>$notes,
            'groupNotesByService_nbr'=>$groupNotesByService_nbr,
            'groupNotesByActivite_nbr'=>$groupNotesByActivite_nbr,
            'moyenneNoteService'=>$moyenneNoteService,
            'moyenneNoteActivite'=>$moyenneNoteActivite,
        ];
        
        
    }
    public function getformationByactiviteDashboeardAdmin(){

        // the current week 
        $startDate = date("Y-m-d", strtotime('monday this week'));  
        $endDate = date("Y-m-d", strtotime('sunday  this week'));  
        //les formations
        $FormationsFc = FormationFc::whereBetween('created_at',[$startDate." 00:00:00",$endDate." 23:59:59"])->get();
        $FormationsFi = FormationFi::whereBetween('created_at',[$startDate." 00:00:00",$endDate." 23:59:59"])->get();
        // les formations initiales 
        $groupByActviteFI = $FormationsFi->groupBy( function ($formation) {
            return $formation->activite->nom;
        });
 
        $groupByActviteFI_nbr = $groupByActviteFI->map(function ($item, $key) {
            return collect($item)->count();
        });
        // les formations continues 
        $groupByActviteFC = $FormationsFc->groupBy( function ($formation) {
            return $formation->activite->nom;
        });
 
        $groupByActviteFC_nbr = $groupByActviteFC->map(function ($item, $key) {
            return collect($item)->count();
        });
        return [
            'groupByActviteFC_nbr'=>$groupByActviteFC_nbr,
            'groupByActviteFI_nbr'=>$groupByActviteFI_nbr,
        ];
    
    
    }

}
