<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\ResponseToMessage;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MessageController extends Controller
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
     * @param  \App\Http\Requests\StoreMessageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = new Message();
        $message->user_id = $request->userId;
        $message->formateur_id = $request->formateurId;
        $message->message = $request->message;
        $message->lu = false ;
        $message->save();
        return 'message_has_send';
    }
    public function getMyMessages(){
        $user = Auth::user();
        $role = $user->getRoleNames()[0];
        $data = [];
        if($role==='formateur'){
            $recivedMessages1 = Message::where('formateur_id',$user->id)->get();
            $recivedMessages = collect($recivedMessages1)->groupBy('user_id'); 
            foreach($recivedMessages as $messageGroupe){
                foreach($messageGroupe as $message){
                    $data[User::find($message->user_id)->nom][]=[
                        'id'=>$message->id,
                        'message'=>$message->message,
                        'agent'=>User::find($message->user_id)->nom,
                        'formateur'=>User::find($message->formateur_id)->nom,
                        'agent_id'=>$message->user_id,
                        'formateur_id'=>$message->formateur_id,
                        'agent_fullName'=>User::find($message->user_id)->nom.' '.User::find($message->user_id)->prenom,
                        'lu'=>$message->lu
                    ];
                }
            }
        }
        if($role==='agent'){
            $recivedMessages1 = ResponseToMessage::where('user_id',$user->id)->get();
            $recivedMessages = collect($recivedMessages1)->groupBy('formateur_id');
            foreach($recivedMessages as $messageGroupe){
                foreach($messageGroupe as $message){
                    $data[User::find($message->formateur_id)->nom][]=[
                        'id'=>$message->id,
                        'message'=>$message->message,
                        'agent'=>User::find($message->formateur_id)->nom,
                        'formateur'=>User::find($message->formateur_id)->nom,
                        'agent_id'=>$message->user_id,
                        'formateur_id'=>$message->formateur_id,
                        'agent_fullName'=>User::find($message->formateur_id)->nom.' '.User::find($message->formateur_id)->prenom,
                        'lu'=>$message->lu
                    ];
                }
            } 
        }
        
     
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMessageRequest  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
