<?php

namespace App\Console\Commands;
use App\Models\NoteAgent;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\RgpdNotify;
use Illuminate\Console\Command;
use Illuminate\Contracts\Queue\ShouldQueue;

class notifyRgpdQuiz extends Command 
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoyer une nouvelle notification pour repasser le quiz RGPD ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rgpdQuizNotes = NoteAgent::where('quizsimplegroup_id',180)->get();
        foreach($rgpdQuizNotes as $rgpdQuizNote){
            if($rgpdQuizNote->created_at < date("Y-m-d h:i:sa") ) {
                Mail::to($rgpdQuizNote->agent->email)->bcc("rkabtour@myopla.com")->queue(new RgpdNotify);
           }
        }
    }
}
