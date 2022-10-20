<?php

namespace App\Http\Controllers;

use App\Models\FinaleQuiz;
use App\Models\Service;
use App\Models\FinaleResponse;
use App\Models\GroupFinaleQuiz;
use App\Models\Instruction;
use Illuminate\Http\Request;

class FinaleQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $FinaleQuiz = GroupFinaleQuiz ::all();
        foreach($FinaleQuiz as $quiz){
            $data[] =[
                'id'=>$quiz->id,

    
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
        $GroupFinaleQuiz = new GroupFinaleQuiz();
        $GroupFinaleQuiz->nom = $request->nom ;
        $GroupFinaleQuiz->activite_id  = $service->activite->id; 
        $GroupFinaleQuiz->save();
    
        foreach($request->questions as $question){
            $FinaleQuiz = new FinaleQuiz();
            $FinaleQuiz->title = $question['title'];
            $FinaleQuiz->service_id = $request->serviceId ;
            $FinaleQuiz->quiz_finale_group_id = $GroupFinaleQuiz->id ;
            $FinaleQuiz->save();
     
            foreach($question['responses'] as $response ){
            $FinaleResponse = new FinaleResponse();
            $FinaleResponse->response = $response['response'];
            if($response['value'] == null){
                $FinaleResponse->value = 0; 
            }
            else {
                $FinaleResponse->value = $response['value'] ;
            }
           
            $FinaleResponse->finale_quiz_id  = $FinaleQuiz->id;
        
            $FinaleResponse->save();
            }  
        }
           return response()->json([
        'id'=>$GroupFinaleQuiz->id,
        'nom'=>  $GroupFinaleQuiz->nom,
    ]);
    }
    public function store2(Request $request){
 
        $Instruction= new Instruction;
        $Instruction->quiz_id = $request->id;
         $fileName = $request->nom.'_'.time().'.'.$request->file->extension();
         $path = $request->file('file')->storeAs('uploads/resources/instructions', $fileName, 'public');
         $Instruction->type='finale';
         $Instruction->url = $path;
         $Instruction->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FinaleQuiz  $finaleQuiz
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        // $QuizSimpleGroup = QuizSimpleGroup::find($id);
        // $Instruction = Instruction::where('quiz_id',$id)->where('type','simple')->first();
     
        // $simpleQuiz = SimpleQuiz:: where('quiz_simple_group_id',$QuizSimpleGroup->id)->get();
        // foreach($simpleQuiz as $quiz){
        //     $responses[] = [
        //         'question'=>$quiz->title,
        //         'responses'=>$quiz->responses,
                

        //     ];
        // }
  
     
        // $data=[
        //     'group'=>$QuizSimpleGroup,
        //     'simple_quiz'=>$simpleQuiz,
        //     'responses'=>$responses,
        //     'Instruction'=>asset(\Storage::url($Instruction->url))
            

        // ] ;
        // return $data;
           // group 
           $QuizSimpleGroup = GroupFinaleQuiz::find($id);
           $Instruction = Instruction::where('quiz_id',$id)->where('type','finale')->first();
           // simple quiz 
           $simpleQuiz = FinaleQuiz:: where('quiz_finale_group_id',$QuizSimpleGroup->id)->get();
           foreach($simpleQuiz as $quiz){
               $responses[] = [
                   'question'=>$quiz->title,
                   'responses'=>$quiz->responses
               ];
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
     * @param  \App\Models\FinaleQuiz  $finaleQuiz
     * @return \Illuminate\Http\Response
     */
    public function edit(FinaleQuiz $finaleQuiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FinaleQuiz  $finaleQuiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FinaleQuiz $finaleQuiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FinaleQuiz  $finaleQuiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(FinaleQuiz $finaleQuiz)
    {
        //
    }
}
