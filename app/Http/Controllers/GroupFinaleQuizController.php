<?php

namespace App\Http\Controllers;

use App\Models\GroupFinaleQuiz;
use Illuminate\Http\Request;

class GroupFinaleQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $GroupFinaleQuiz = GroupFinaleQuiz::all()->groupBy('activite_id');
       
        foreach($GroupFinaleQuiz as $quiz){
            $data[]=[
             
               
                 'activite'=>$quiz[0]->activite->nom,
       
 
 
            ];
        }
        return $data;
    }
    public function index2()
    {
        
        $GroupFinaleQuiz = GroupFinaleQuiz::all();
        return $GroupFinaleQuiz;
       
     
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
     * @param  \App\Models\GroupFinaleQuiz  $groupFinaleQuiz
     * @return \Illuminate\Http\Response
     */
    public function show(GroupFinaleQuiz $groupFinaleQuiz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GroupFinaleQuiz  $groupFinaleQuiz
     * @return \Illuminate\Http\Response
     */
    public function edit(GroupFinaleQuiz $groupFinaleQuiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GroupFinaleQuiz  $groupFinaleQuiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GroupFinaleQuiz $groupFinaleQuiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GroupFinaleQuiz  $groupFinaleQuiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroupFinaleQuiz $groupFinaleQuiz)
    {
        //
    }
}
