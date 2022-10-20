<?php

namespace App\Http\Controllers;

use App\Models\ResponseAgent;
use Illuminate\Support\Facades\Auth;
use App\Models\NoteAgent;
use Illuminate\Http\Request;
use App\Models\SimpleResponse;
use App\Models\QuizSimpleGroup;
use App\Models\User;
use App\Models\Instruction;
use App\Models\SimpleQuiz;
class ResponseAgentController extends Controller
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
         $NoteAgent = new NoteAgent();
        $NoteAgent->quiz_id = $request->quiz_id ;
        $NoteAgent->type = $request->type;
        $NoteAgent->note = 0 ;
        $NoteAgent->type = $request->type;
        foreach($request->responseAgent  as  $response){
            
            $ResponseAgent = new ResponseAgent();
            $ResponseAgent->agent_id = $request->user_id;
         
            foreach($response['responses'] as $res){
                $ResponseAgent->response = $res['response'];
                if($res['value']===true ){
               
                
                
                    $ResponseAgent->value = 1;
                    $ResponseAgent->save(); 
                    $NoteAgent->note += 5/intval ((count($response['responses'])/2));
                }
                else if( $res['value']==0 ){
                 
                   
        
                    $ResponseAgent->value = 0;
                    $ResponseAgent->save(); 
                }
           
            }
        }
        
       
       

        $NoteAgent->save();
      
    }
    public function agentsResponse(Request $request){
        
        if(NoteAgent::where('quizsimplegroup_id' ,$request->quiz_id)->where('agent_id',$request->user_id)->first()){
            return 'exist';
        }
        else {
     
    $this->storeAgenResponses($request->responseAgent,$request->user_id);
     $NoteAgent = new NoteAgent();
     $NoteAgent->quizsimplegroup()->associate($request->quiz_id);
     $NoteAgent->agent()->associate(  $request->user_id );
     $NoteAgent->type = $request->type;
     $NoteAgent->note = $request->note;
     $NoteAgent->activite_id = $request->activite_id;
     $NoteAgent->service_id  = $request->service_id;
     $NoteAgent->save();              
    }
      
    }
    public function getAgentNotes(){
        $user = Auth::user();
   
        $data = [];
        $userActivitys = $user->activite;
        
        if(count($userActivitys)!=0){
           
            foreach($userActivitys as $activity){
              
                $NoteAgent=NoteAgent::where('activite_id',$activity->id)->get();
                foreach($NoteAgent as $note){
                    if($note->type=='simple'){
                        $data[]=[
                            'id'=> $note->id,
                          'formation'=>$note->quizsimplegroup->nom,
                           'agent'=> $note->agent->nom.' '.$note->agent->prenom ,
                           'quiz_simple_groups_id'=>$note->quizsimplegroup_id ,
                           'agent_id'=>$note->agent->id,
                           'note'=>$note->note,
                           'activite'=>$note->activite->nom,
                           'service'=>$note->service->nom,
        
                        ];
                    }
                }
            }
        }
        else {
            $NoteAgent=NoteAgent::all();
            foreach($NoteAgent as $note){
                if($note->type=='simple'){
                    $data[]=[
                        'id'=> $note->id,
                      'formation'=>$note->quizsimplegroup->nom,
                       'agent'=> $note->agent->nom.' '.$note->agent->prenom ,
                       'quiz_simple_groups_id'=>$note->quizsimplegroup_id ,
                       'agent_id'=>$note->agent->id,
                       'note'=>$note->note,
                       'activite'=>$note->activite->nom,
                       'service'=>$note->service->nom,
    
                    ];
                }
            }
        }
      if(count($data)==0) return 'nodatafound' ;
        return $data ;

        
    }
    public function getAgentNotesFilter(Request $request){
        $data = [];
        $NoteAgent=NoteAgent::where('activite_id',$request->actviteId)->where('service_id',$request->serviceId)->get();
        foreach($NoteAgent as $note){
            if($note->type=='simple'){
                $data[]=[
                  'formation'=>$note->quizsimplegroup->nom,
                   'agent'=> $note->agent->nom.' '.$note->agent->prenom ,
                   'quiz_simple_groups_id'=>$note->quizsimplegroup_id ,
                   'agent_id'=>$note->agent->id,
                   'note'=>$note->note,
                   'activite'=>$note->activite->nom,
                   'service'=>$note->service->nom,

                ];
            }
        }
        if(count($data)===0) return 'nodatafound';
        return $data ;
    }
    public function getResponseAgentDetail(Request $request){
       
        $QuizSimpleGroup=QuizSimpleGroup::find($request->group_quiz_id);
        $questions = $QuizSimpleGroup->SimpleQuizs;
        
        $note=NoteAgent::where('quizsimplegroup_id' ,$request->group_quiz_id)->where('agent_id',$request->agent_id)->first();
       foreach( $questions as $question) {
           
           $data[$question->title] =[ 
               
          'agentResponse'=>ResponseAgent::where('agent_id',$request->agent_id)->where('simple_quiz_id',$question->id)->get(),
          'trueResponse'=>$question->responses,
          
           ];
        }
       return [
        
            'responses'=> $data,
            'agent'=>$note->agent->nom.' '.$note->agent->prenom,
            'note'=>$note->note ];

          
        foreach($responseAgent as $anwser1){
        foreach($anwser1 as $anwser){
            $data[]= 
            [   'question'=>$anwser->SimpleQuiz->title,
                'trueResponse'=>$anwser->SimpleResponse,
                'agentResponse'=>$anwser->SimpleResponse->responseAgent
                
          ]; // tous les reponse
        }
        }
        
       foreach($data as $d){
        //    return $d['question'];
        $groupbyAgent[$d['question']][] =[ 
            
          'agentResponse'=>  $d['agentResponse'],
          'trueResponse'=> $d['trueResponse']
        ]; 
       }
    return [
        
       'responses'=> $groupbyAgent,
       'agent'=>$note->agent->nom.' '.$note->agent->prenom,
       'note'=>$note->note ];
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResponseAgent  $responseAgent
     * @return \Illuminate\Http\Response
     */
    public function show(ResponseAgent $responseAgent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ResponseAgent  $responseAgent
     * @return \Illuminate\Http\Response
     */
    public function edit(ResponseAgent $responseAgent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResponseAgent  $responseAgent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ResponseAgent $responseAgent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResponseAgent  $responseAgent
     * @return \Illuminate\Http\Response
     */
    public function delete($id )
    {
        $NoteAgent=NoteAgent::find($id);
        $NoteAgent->delete();
    }
    public function storeAgenResponses($array,$user_id){
        foreach($array as $response){ 
            foreach($response['responses'] as $AgentResponse){
                $ResponseAgent = new ResponseAgent();
                $ResponseAgent->agent()->associate($user_id);
                $ResponseAgent->type = 'simple';
                $ResponseAgent->SimpleResponse()->associate($AgentResponse['id']);
                $ResponseAgent->SimpleQuiz()->associate($AgentResponse['quiz_simple_id']);
                $ResponseAgent->response =$AgentResponse['response']; 
                if(isset( $AgentResponse['value']) ){
                    $ResponseAgent->value =$AgentResponse['value'];
                }
                else {
                    $ResponseAgent->value = 0; 
                }         
                    
               $ResponseAgent->save(); 
                               
            } 
    }
}
}
