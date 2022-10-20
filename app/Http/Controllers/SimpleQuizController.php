<?php

namespace App\Http\Controllers;

use App\Models\SimpleQuiz;
use App\Models\Activite;
use App\Models\Service;
use App\Models\QuizSimpleGroup;
use Illuminate\Http\Request;
use App\Models\SimpleResponse;
use App\Models\Instruction;
use Storage;
use DB;
class SimpleQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $SimpleQuiz =SimpleQuiz::all();
     foreach($SimpleQuiz as $quiz){
        $data[] =[
            'id'=>$quiz->id,
            'title'=>$quiz->title,
            'service'=>$quiz->service->nom

        ];
     }
     return $data ;
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

        $service = Service::find($request->serviceId);

        $QuizSimpleGroup = new QuizSimpleGroup();
        $QuizSimpleGroup->nom = $request->nom ;
         $QuizSimpleGroup->site = $request->site ;
        $QuizSimpleGroup->service_id  =  $service->id; 
        $QuizSimpleGroup->activite_id  =  $service->activite->id; 
        $QuizSimpleGroup->save();

        foreach($request->questions as $question){
         
            $SimpleQuiz = new SimpleQuiz(); // question
            $SimpleQuiz->title = $question['title'];
            $SimpleQuiz->service_id = $request->serviceId ;
            $SimpleQuiz->quiz_simple_group_id = $QuizSimpleGroup->id ;
            $SimpleQuiz->save(); 
            foreach($question['responses'] as $response ){   
               
                $SimpleResponse = new SimpleResponse();
                if($response['value'] == null){
                    $SimpleResponse->value = 0; 
                }
                else {
                    $SimpleResponse->value = $response['value'] ;
                }
                $SimpleResponse->simple_quiz_id  =$SimpleQuiz->id;
                $SimpleResponse->response = $response['response'];
                $SimpleResponse->save();
               
                }
         
        }
        return response()->json([
            'id'=>$QuizSimpleGroup->id,
            'nom'=>  $QuizSimpleGroup->nom,
        ]);
    
        
        
    }
    public function store2(Request $request){
        $Instruction= new Instruction;
       $Instruction->quiz_id = $request->id;
        $fileName = $request->nom.'_'.time().'.'.$request->file->extension();
        $path = $request->file('file')->storeAs('uploads/resources/instructions', $fileName, 'public');
        $Instruction->type='simple';
        $Instruction->url = $path;
        $Instruction->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SimpleQuiz  $simpleQuiz
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      
         // group 
        $QuizSimpleGroup = QuizSimpleGroup::find($id);
        $Instruction = Instruction::where('quiz_id',$id)->where('type','simple')->first();
        $simpleQuiz = SimpleQuiz:: where('quiz_simple_group_id',$QuizSimpleGroup->id)->get();
        foreach($simpleQuiz as  $quiz){
            foreach($quiz->responses as $key=> $resp){
               $tem[]=[
                   'id'=>$resp->id,
                   'quiz_simple_id'=>$resp->simple_quiz_id,
                   'response'=>$resp->response,
                   'value_response'=>$resp->value       
               ];
            }
            foreach($quiz->responses as $key=> $resp){
                $tem2[]=[
                    'value'=>$resp->value      
                ];
            }
            $trueResponse = 1;
            // if(in_array($trueResponse,$tem2))
             $countTrue = array_count_values(array_column($tem2, 'value'))[$trueResponse]; 
            $responses[] = [
                'question'=>$quiz->title,
                'responses'=>$tem,
                'trueResponse'=>$countTrue
                 
            ];
             $countTrue = 0;
            $tem = [];
            $tem2 = [];
           
           
        }
      
     
        $data=[
            'group'=>$QuizSimpleGroup,
            'simple_quiz'=>$simpleQuiz,
            'responses'=>$responses,
            'Instruction'=>asset(\Storage::url($Instruction->url))
            

        ] ;
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SimpleQuiz  $simpleQuiz
     * @return \Illuminate\Http\Response
     */
    public function edit(SimpleQuiz $simpleQuiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SimpleQuiz  $simpleQuiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SimpleQuiz $simpleQuiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SimpleQuiz  $simpleQuiz
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request;
        $QuizSimpleGroup = QuizSimpleGroup::find($id); 
   
        $Instruction = Instruction::where('quiz_id',$id)->where('type','simple')->first();
        if($Instruction){
            Storage::disk('public')->delete($Instruction->url);
            $Instruction->delete();
     
        }   
        $simpleQuiz = SimpleQuiz:: where('quiz_simple_group_id',$QuizSimpleGroup[0]->id)->get();
        foreach($simpleQuiz as $quiz){   
            foreach($quiz->responses as $res){
                 DB::table('response_agents')->where('simple_response_id',$res->id)->delete();
                // detache :  response_agents/response_agents_simple_response_id_foreign
               $res->delete();
            }
            $quiz->delete();
        }
       DB::table('note_agents')->where('quizsimplegroup_id',$QuizSimpleGroup[0]->id)->delete();
       $QuizSimpleGroup[0]->delete();
  
    }
    public function count(){
        $QuizSimpleGroup = QuizSimpleGroup::all();
        return count($QuizSimpleGroup);
    }
   
}
