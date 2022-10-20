<?php

namespace App\Http\Controllers;

use App\Models\ResponseToMessage;
use App\Http\Requests\StoreResponseToMessageRequest;
use App\Http\Requests\UpdateResponseToMessageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResponseToMessageController extends Controller
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
     * @param  \App\Http\Requests\StoreResponseToMessageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $role = $user->getRoleNames()[0];
        $response = new ResponseToMessage();
        $response->message = $request->message;
        if($role === 'formateur'){
            $response->formateur_id = $user->id;
            $response->user_id = $request->agent_id;
        }
        $response->lu = false ;
        $response->save();
        return 'message_has_send';
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResponseToMessage  $responseToMessage
     * @return \Illuminate\Http\Response
     */
    public function show(ResponseToMessage $responseToMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ResponseToMessage  $responseToMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(ResponseToMessage $responseToMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateResponseToMessageRequest  $request
     * @param  \App\Models\ResponseToMessage  $responseToMessage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateResponseToMessageRequest $request, ResponseToMessage $responseToMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResponseToMessage  $responseToMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResponseToMessage $responseToMessage)
    {
        //
    }
}
