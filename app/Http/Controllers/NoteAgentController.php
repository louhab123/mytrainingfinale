<?php

namespace App\Http\Controllers;

use App\Models\NoteAgent;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NotesAgentsExport;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NoteAgentController extends Controller
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
     * @param  \App\Models\NoteAgent  $noteAgent
     * @return \Illuminate\Http\Response
     */
    public function show(NoteAgent $noteAgent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NoteAgent  $noteAgent
     * @return \Illuminate\Http\Response
     */
    public function edit(NoteAgent $noteAgent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NoteAgent  $noteAgent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NoteAgent $noteAgent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NoteAgent  $noteAgent
     * @return \Illuminate\Http\Response
     */
    public function destroy(NoteAgent $noteAgent)
    {
        //
    }
    public function export(){
        $notes = NoteAgent::all();
        $data = [];
        foreach($notes as $note){
            $data[]=[
                'formation'=>$note->quizsimplegroup->nom,
                'agent'=> $note->agent->nom.' '.$note->agent->prenom ,
                'note'=>$note->note,
                'date'=> Carbon::createFromDate($note->created_at)->format('Y-m-d'),
                'activite'=>$note->activite->nom,
                'service'=>$note->service->nom,
                'site'=>$note->quizsimplegroup->site
            ];
        }
       
        return Excel::download(new NotesAgentsExport($data), 'Les_notes-des_agents.xlsx');
    
    }
  
}
