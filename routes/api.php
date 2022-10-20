<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\ActiviteController;
use App\Http\Controllers\ServiceController;
USE App\Http\Controllers\FormationFcController;
use App\Http\Controllers\FormationFiController;
use App\Http\Controllers\AgentVagueController;
use App\Http\Controllers\VagueController;
use App\Http\Controllers\AgentStateOfPresenceController;
use  App\Http\Controllers\AgentStateOfPresenceDetailsController;
use App\Http\Controllers\ResourcesController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\SimpleQuizController ;
use App\Http\Controllers\FinaleQuizController;
use App\Http\Controllers\QuizSimpleGroupController ;
use App\Http\Controllers\ReportingController;
use App\Http\Controllers\ResponseAgentController;
use App\Http\Controllers\GroupFinaleQuizController ;
use App\Http\Controllers\UserController ;
use App\Http\Controllers\AncienfiController;
use App\Http\Controllers\RolesTest ;
use App\Http\Controllers\NoteAgentController ;
use App\Http\Controllers\MessageController ;

use App\Http\Controllers\ResponseToMessageController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login',[AuthController::class,'login']);
Route::get('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
Route::get('getAgents',[AgentController::class,'index']);
Route::get('getActivities',[ActiviteController::class,'index'])->middleware('auth:sanctum');
Route::get('getServices',[ServiceController::class,'index'])->middleware('auth:sanctum');
// start formation 


Route::group(['prefix' => 'formation'],function () {
    Route::post('startFormationFiPost',[FormationFiController::class,'store'])->middleware('auth:sanctum');
    Route::post('startFormationFCPost',[FormationFcController::class,'store'])->middleware('auth:sanctum');
    Route::get('getFormations',[FormationFcController::class,'index'] )->middleware('auth:sanctum');
    
    Route::get('getFormationsgetAll',[FormationFcController::class,'getAll'] )->middleware('auth:sanctum');
    Route::get('getFormationsDetail/{id}',[VagueController::class,'index'] )->middleware('auth:sanctum');
    Route::post('addResource',[ResourcesController::class, 'store'])->middleware('auth:sanctum');
    Route::post('addVideo',[VideoController::class, 'store'])->middleware('auth:sanctum');
    Route::get('/count/vagues',[VagueController::class,'count'] )->middleware('auth:sanctum');
    Route::get('/count/fc',[FormationFcController::class,'count'] )->middleware('auth:sanctum');
    Route::get('/count/fi',[FormationFiController::class,'count'] )->middleware('auth:sanctum');
    Route::get('/count/effitive',[VagueController::class,'counteffitive'] )->middleware('auth:sanctum');
    Route::post('getMyFormations',[FormationFcController::class,'getMyFormations'] )->middleware('auth:sanctum');
    Route::get('/getmyformationsAll', [FormationFiController::class,'getmyformationsAll'])->middleware('auth:sanctum');
    Route::post('deleteMyformation',[FormationFiController::class,'deleteMyformation'])->middleware('auth:sanctum');
});

Route::group(['prefix' => 'agent'],function () {
    
    Route::get('notes/extraire',[NoteAgentController::class,'export'])->middleware('auth:sanctum');
    Route::get('count',[AgentController::class,'count'])->middleware('auth:sanctum');
    Route::get('all',[AgentController::class,'getAllAgentVague'])->middleware('auth:sanctum');
    Route::post('add',[AgentController::class,'store'])->middleware('auth:sanctum');
    Route::post('add2',[AgentController::class,'store2'])->middleware('auth:sanctum');
    Route::post('selectedAgent',[AgentController::class,'selectedAgent'])->middleware('auth:sanctum');
    Route::get('getAgentdetails/{id}',[AgentController::class,'getAgentdetails'])->middleware('auth:sanctum');
});

Route::group(['prefix' => 'state'],function () {
    Route::post('statofpresence',[AgentStateOfPresenceController::class,'store'])->middleware('auth:sanctum');
    
    Route::get('getComuleStateOfPresence/{formation_type}/{formation_id}',[AgentStateOfPresenceController::class,'show'])->middleware('auth:sanctum');
    Route::get('getDetailsStateOfPrsence/{formation_type}/{formation_id}',[AgentStateOfPresenceDetailsController::class,'show'])->middleware('auth:sanctum');

});

Route::group(['prefix'=>'quiz', 'middleware'=>'auth:sanctum'],function (){
   Route::post('addSimpleQuiz', [SimpleQuizController::class , 'store']); 
   Route::post('addSimpleQuizInstructions', [SimpleQuizController::class , 'store2']);   
   Route::get('count', [SimpleQuizController::class , 'count']);   
   Route::get('all', [QuizSimpleGroupController::class , 'index']);
   Route::get('all3/{id}', [QuizSimpleGroupController::class , 'index2']);
   Route::get('all4/{id}', [GroupFinaleQuizController::class , 'index2']);
   Route::get('all2', [GroupFinaleQuizController::class , 'index']);
   Route::get('{id}', [SimpleQuizController::class , 'show']);
   Route::get('finale/{id}', [FinaleQuizController::class , 'show']);
   Route::post('addFinaleQuiz',[FinaleQuizController::class , 'store']);
   Route::post('addFinaleQuizInstruction', [FinaleQuizController::class , 'store2']); 
   Route::post('deleteQuizSimple',[SimpleQuizController::class , 'delete']);
});

Route::group(['prefix'=>'resource'], function(){
    Route::get('/2/{id}',[ResourcesController::class , 'get2'])->middleware('auth:sanctum');
    Route::get('all',[ResourcesController::class , 'index'])->middleware('auth:sanctum');
    Route::get('/geteResource/{id}',[ResourcesController::class,'show'])->middleware('auth:sanctum');
    Route::get('/geteResource2/{id}',[ResourcesController::class,'show2'])->middleware('auth:sanctum');
    Route::get('/delete/{id}',[ResourcesController::class,'delete'])->middleware('auth:sanctum');
    Route::post('/edit',[ResourcesController::class,'edit'])->middleware('auth:sanctum');
});

Route::group(['prefix'=>'videos'],function(){
    Route::get('all',[VideoController::class , 'index'])->middleware('auth:sanctum');
    Route::get('/ShowVdeo/{id}',[VideoController::class , 'show'])->middleware('auth:sanctum');
    Route::get('/ShowVdeo2/{id}',[VideoController::class , 'show2'])->middleware('auth:sanctum');
});
// reporting/getGlobaleReporting

Route::group(['prefix'=>'reporting'], function(){
    // reporting
   Route::post('getGlobaleReporting',[ReportingController::class, 'globaleReporting']);
   Route::post('getReportingActvity',[ReportingController::class, 'getReportingActvity']);
   Route::post('getReportingbySerice',[ReportingController::class, 'getReportingbySerice']);
   
   Route::post('getReportingbyAgent',[ReportingController::class, 'getReportingbyAgent']);
   // fin reporting 
   Route::get('byService',[ReportingController::class, 'byService']);
   Route::get('getFormationsByActviteAnsService2',[ReportingController::class, 'getFormationsByActviteAnsService2']);
   Route::get('getFormationsByActviteAnsService',[ReportingController::class, 'getFormationsByActviteAnsService']);
   
   Route::get('getQuizSimpleByActvite',[ReportingController::class, 'getQuizSimpleByActvite']);
});
Route::group(['prefix'=>'note','middleware' => 'auth:sanctum'], function(){
    Route::post('sendDataAgent',[ResponseAgentController::class, 'agentsResponse']);
    Route::get('getAgentNotes',[ResponseAgentController::class, 'getAgentNotes']);
    Route::post('getAgentNotesFilter',[ResponseAgentController::class,'getAgentNotesFilter']);
    Route::post('getResponseAgentDetail',[ResponseAgentController::class, 'getResponseAgentDetail']);
    Route::post('sendDataAgentSimpleQuiz',[ResponseAgentController::class, 'store2']);
    Route::get('delete/{id}',[ResponseAgentController::class,'delete']);
 });
 Route::group(['prefix'=>'vagues'], function(){
    Route::get('all',[VagueController::class,'getAll'] )->middleware('auth:sanctum');
    Route::get('effectiveByWeeek',[AgentVagueController::class,'effectiveByWeeek'] )->middleware('auth:sanctum');
 });
// create roles 

Route::get('creete_roles',[RolesTest::class,'creete_roles']);
Route::get('password',[RolesTest::class,'password']);
Route::get('agent',[RolesTest::class,'agent']);

Route::get('create_agent',[RolesTest::class,'create_agent']);
Route::get('createPermissionsAndRoles',[RolesTest::class,'createPermissionsAndRoles']);

Route::get('moveAgents',[RolesTest::class,'moveAgents']);
Route::group(['prefix'=>'users', 'middleware' => 'auth:sanctum'],function(){
       Route::post('add',[UserController::class,'store']);
       Route::get('show',[UserController::class, 'show']);
       Route::post('edit',[UserController::class,'edit']);
       Route::get('getFormateurs',[UserController::class,'getFormateurs']);
       Route::get('getClients',[UserController::class,'getClients']);
        Route::get('getadmins',[UserController::class,'getadmins']);
});
Route::group(['prefix'=>'services','middleware' => 'auth:sanctum'],function(){
    Route::get('show2/{id}',[ServiceController::class,'show']);
    Route::get('show3/{id}',[ServiceController::class,'getService']);
    Route::post('add',[ServiceController::class,'store']);
   Route::post('/edit', [ServiceController::class , 'edit']);
   Route::post('/editName', [ServiceController::class , 'editName']);
});
Route::group(['prefix'=>'dashboard','middleware'=> 'auth:sanctum'],function(){
     Route::get('getformationByactiviteDashboeardAdmin',[ReportingController::class,'getformationByactiviteDashboeardAdmin']);  
});
Route::group(['prefix'=>'activities','middleware'=>'auth:sanctum'],function(){
    Route::post('edit',[ActiviteController::class,'edit']);
    Route::post('add',[ActiviteController::class,'store']);
    Route::post('changeActivitieImage',[ActiviteController::class,'changeActivitieImage']);
});
Route::group(['prefix'=>'historique','middleware'=>'auth:sanctum'],function(){
    Route::get('getAncienFis',[AncienfiController::class,'index']);
});
Route::group(['prefix'=>'messages','middleware'=>'auth:sanctum'],function(){
    Route::post('send',[MessageController::class,'store']);
    Route::get('getMyMessages',[MessageController::class,'getMyMessages']);
    Route::post('answerToAgentMessage',[ResponseToMessageController::class,'store']);
});