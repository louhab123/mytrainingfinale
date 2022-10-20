<?php

namespace App\Http\Controllers;

use App\Models\QuizSimpleGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Activite;
use App\Models\Agent;

class QuizSimpleGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data= [];
        $user = Auth::user();
        if($user->getRoleNames()[0]  == 'client'){
            $userActivitys = $user->activite;
            foreach($userActivitys as $activity){
                $QuizSimpleGroup = QuizSimpleGroup::where('activite_id',$activity->id)->get(); 
                foreach($QuizSimpleGroup as $quiz){
                    $data[]=[
                        'id'=>$quiz->activite->id,
                        'activite'=>$quiz->activite->nom,
                        'image_url'=>($quiz->activite->image_url ==null)? '' : asset(\Storage::url($quiz->activite->image_url)),
                    ];
                   
            }
            }
        }
        else {
            $QuizSimpleGroup = QuizSimpleGroup::all();
            foreach($QuizSimpleGroup as $quiz){
                $data[]=[
                    'id'=>$quiz->activite->id,
                    'activite'=>$quiz->activite->nom,
                    'image_url'=>($quiz->activite->image_url ==null)? '' : asset(\Storage::url($quiz->activite->image_url)),
                ];
               
        }
       
        }
         
        
        return $this->my_array_unique($data);

 }
 public function index2($id)
 {

     $QuizSimpleGroup = QuizSimpleGroup::where('activite_id',$id)->get();
     return $QuizSimpleGroup ;
   

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
     * @param  \App\Models\QuizSimpleGroup  $quizSimpleGroup
     * @return \Illuminate\Http\Response
     */
    public function show(QuizSimpleGroup $quizSimpleGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuizSimpleGroup  $quizSimpleGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(QuizSimpleGroup $quizSimpleGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuizSimpleGroup  $quizSimpleGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuizSimpleGroup $quizSimpleGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuizSimpleGroup  $quizSimpleGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuizSimpleGroup $quizSimpleGroup)
    {
        //
    }
    function my_array_unique($array, $keep_key_assoc = false){
        $duplicate_keys = array();
        $tmp = array();       
    
        foreach ($array as $key => $val){
            // convert objects to arrays, in_array() does not support objects
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
