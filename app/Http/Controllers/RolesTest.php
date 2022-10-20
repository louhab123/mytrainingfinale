<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agent;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Hash;

class RolesTest extends Controller
{
    public function moveQstoUsers() {
        $qualiticiens = Qualiticien::all();
        foreach($qualiticiens as $q) {
            $tempQ =  User::firstOrNew(['id'=> $q->id]);
	        $tempQ->id = $q->id;
            $tempQ->nom =  $q->nom;
            $tempQ->prenom =  $q->prenom;
            $tempQ->telephone =  $q->telephone;
            $tempQ->matricule =  $q->matricule;
            $tempQ->email =  $q->email;
            $tempQ->password =  $q->password;
            $role = Role::where('name','qualiticien')->first();
            $tempQ->assignRole($role);
            $tempQ->save();
        }
        return 'qualiticiens moved to users';
    }
    public function moveAdminsToUsers() {

        $admins = Admin::all();

        foreach($admins as $a) {
            $tempA = User::firstOrNew(['email'=> $a->email]);
            //$tempA->id = $a->id;
            $tempA->nom =  $a->nom;
            $tempA->prenom =  $a->prenom;
            $tempA->telephone =  $a->telephone;
            $tempA->matricule =  $a->matricule;
            $tempA->password =  $a->password;
            $role = Role::where('name','admin')->first();
            $tempA->assignRole($role);
            $tempA->save();
        }
        return 'admins moved to users';
    }
    /*
    public function moveQualiticienIdToUserIdOnevalTable() {
        $evals = Evaluation::all();
        foreach($evals as $e) {
            $e->user_qualiticien_id = $e->qualiticien_id ;
            $e->save();
        }
    }*/

    public function testmiddleware() {
        return 'passsed';
    }

   public function test(){

        $user = User::find(1);

        /*$role = Role::find(3);//where('name','admin')->get();*/
        //$role = Role::create(['guard_name' => 'api', 'name' => 'manager']);
        //$permissions = Permission::find([2,3,4,5,6,7,8,9,10]);
        //$role->syncPermissions($permissions);

        $user->assignRole([8]);
        return $user;
        /*

        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);

        */
   }

   public function createPermissionsAndRoles() {
        // create permissions
        $permissions = [
            'Auth',
            'admin-dashboard',
            'agent-dashboard',
            'formateur-dashboard',
            'client-dashboard',
            'start-fi',
            'start-fc',
            'my-formations',
            'all-formations',
            'add-support',
            'add-module',
            'add-quiz',
            'add-video',
            'supports-liste',
            'modules-liste',
            'videos-liste',
            'quizs-liste',
            'reporting-globale',
            'reporting-activite',
            'reporting-service',
            'reporting-agent',
            'agents-liste',
            'notes-liste',
            'users-liste',
            'users-add',
            'start-formation',
            'quiz-details',
            'reporting',
            'users',
            'activitees-list',
            'activite-services',
            'agents',
            'historique-dashboard',
            'historique-fis',

        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
        $adminpermission = Permission::whereIn('name',['Auth' ,'historique-dashboard', 'historique-fis','activitees-list','activite-services','users', 'agents','reporting','start-formation','quiz-details','admin-dashboard','start-fi','start-fc','my-formations','all-formations','add-support','add-module','add-quiz','add-video','supports-liste','modules-liste','videos-liste','quizs-liste','reporting-globale','reporting-activite','reporting-service','reporting-agent','agents-liste','notes-liste','users-liste','users-add'])->get();
        $formateurpermission = Permission::whereIn('name',['Auth' , 'agents','reporting','start-formation','quiz-details','formateur-dashboard','start-fi','start-fc','my-formations','add-support','add-module','add-quiz','add-video','supports-liste','modules-liste','videos-liste','quizs-liste','reporting-globale','reporting-activite','reporting-service','reporting-agent','agents-liste','notes-liste'])->get();
        $agentpermission = Permission::whereIn('name',['Auth', 'quiz-details','agent-dashboard','supports-liste','modules-liste','videos-liste','quizs-liste',  ])->get();
        $clientpermission = Permission::whereIn('name',['Auth', 'agents', 'notes-liste' ,'add-support','add-module','add-quiz','add-video','reporting-activite','reporting-service', 'reporting' ,'quiz-details','client-dashboard','supports-liste','modules-liste','videos-liste','quizs-liste'])->get();
        $roles = [
         ['admin',$adminpermission] ,  
        ['client',$clientpermission],
        ['formateur',$formateurpermission],
        ['agent',$agentpermission],
        ];

        foreach ($roles as $role) {
            $r = Role::firstOrNew(['name' => $role[0], 'guard_name' => 'web']);
            $r->syncPermissions($role[1]);
	        $r->save();
        }
   }
   public function moveAgentsToUsers() {

    $agent = Agent::all();

    foreach($agent as $a) {
        $tempA = User::firstOrNew(['email'=> $a->email]);
        //$tempA->id = $a->id;
        $tempA->nom =  $a->nom;
        $tempA->prenom =  $a->prenom;
        $tempA->telephone =  $a->telephone;
        $tempA->matricule =  $a->matricule;
        $tempA->password =  password_hash('password',PASSWORD_DEFAULT);
        $role = Role::where('name','agent')->first();
        $tempA->assignRole($role);
        $tempA->save();
    }
    return 'agent moved to users';
}
public function assingRole(){
    $user =User::find(109);
    $role = Role::where('name','superviseur')->first();
    $user->assignRole($role);
}
public function getAgent() {
    $agent =Agent::find(778);

}
    public function creete_roles(){
        // $roleFormateur = Role::create(['name' => 'formateur']);
        // $roleAgent = Role::create(['name' => 'agent']);
        // $roleClient = Role::create(['name' => 'client']);
        //  $roleClient = Role::create(['name' => 'admin']);
             $user = User::where('email','rkabtour@myopla.com')->first();
             $role = Role::where('name','admin')->first();
              $user->assignRole($role);
        // foreach($users as $user){
           
        //     if(Agent::where('email',$user->email)->first()){
        //          $role = Role::where('name','agent')->first();
        //          $user->assignRole($role);
        //     }
        //     else {
        //         $role = Role::where('name','formateur')->first();  
        //      $user->assignRole($role);
        //     }
        // }
    }
    public function password(){
        return  bcrypt('2753');
    }
    public function agent(){
        $user = User::find(120000);
        $role = Role::where('name','agent')->first();
        $user->assignRole($role);
        $user->save();

    }
    public function create_agent(){
        if(!Agent::where('email','abenmessaoudleft@myopla.com')->first()){
            $agent= new Agent();
            $agent->nom="BENMESSAOUD LEFT";
            $agent->prenom="adil";
            $agent->email="abenmessaoudleft@myopla.com";
            $agent->service_id="62";
            $agent->save();
        }
        if(!User::where('email','abenmessaoudleft@myopla.com')->first()){
            $user = new User();
            $user->nom = "BENMESSAOUD LEFT";
            $user->prenom = "adil";
            $user->email="abenmessaoudleft@myopla.com";
            $user->password=password_hash('password',PASSWORD_DEFAULT);
            $role = Role::where('name','agent')->first();
            $user->assignRole($role);
            $user->save();
        }
        else {
           $user= User::where('email','abenmessaoudleft@myopla.com')->first();
           $model_role= DB::table('model_has_roles')->where('model_id',$user->id)->update(['role_id' => 6]);   
        }
        // //
        if(!Agent::where('email','falguerrab@myopla.com')->first()){
            $agent= new Agent();
            $agent->nom="AL GUERRAB";
            $agent->prenom="Fatima Zahra";
            $agent->email="falguerrab@myopla.com";
            $agent->service_id="62";
            $agent->save();
        }
        if(!User::where('email','falguerrab@myopla.com')->first()){
            $user = new User();
            $user->nom = "AL GUERRAB";
            $user->prenom = "Fatima Zahra";
            $user->email="falguerrab@myopla.com";
            $user->password=password_hash('password',PASSWORD_DEFAULT);
            $role = Role::where('name','agent')->first();
            $user->assignRole($role);
            $user->save();
        }
        else {
           $user= User::where('email','falguerrab@myopla.com')->first();
           $model_role= DB::table('model_has_roles')->where('model_id',$user->id)->update(['role_id' => 6]);   
        }
         // // 
         if(!Agent::where('email','nghachane@myopla.com')->first()){
            $agent= new Agent();
            $agent->nom="GHACHANE";
            $agent->prenom="NAIMA";
            $agent->email="nghachane@myopla.com";
            $agent->service_id="62";
            $agent->save();
        }
        if(!User::where('email','nghachane@myopla.com')->first()){
            $user = new User();
            $user->nom = "GHACHANE";
            $user->prenom = "NAIMA";
            $user->email="nghachane@myopla.com";
            $user->password=password_hash('password',PASSWORD_DEFAULT);
            $role = Role::where('name','agent')->first();
            $user->assignRole($role);
            $user->save();
        }
        else {
           $user= User::where('email','nghachane@myopla.com')->first();
           $model_role= DB::table('model_has_roles')->where('model_id',$user->id)->update(['role_id' => 6]);   
        }
         // //
         if(!Agent::where('email','aelakkioui@myopla.com')->first()){
            $agent= new Agent();
            $agent->nom="EL AKKIOUI";
            $agent->prenom="AYOUB";
            $agent->email="aelakkioui@myopla.com";
            $agent->service_id="62";
            $agent->save();
        }
        if(!User::where('email','aelakkioui@myopla.com')->first()){
            $user = new User();
            $user->nom = "EL AKKIOUI";
            $user->prenom = "AYOUB";
            $user->email="aelakkioui@myopla.com";
            $user->password=password_hash('password',PASSWORD_DEFAULT);
            $role = Role::where('name','agent')->first();
            $user->assignRole($role);
            $user->save();
        }
        else {
           $user= User::where('email','aelakkioui@myopla.com')->first();
           $model_role= DB::table('model_has_roles')->where('model_id',$user->id)->update(['role_id' => 6]);   
        }
        // //
        if(!Agent::where('email','sbahbah@myopla.com')->first()){
            $agent= new Agent();
            $agent->nom="BAHBAH";
            $agent->prenom="SAAD";
            $agent->email="sbahbah@myopla.com";
            $agent->service_id="62";
            $agent->save();
        }
        if(!User::where('email','sbahbah@myopla.com')->first()){
            $user = new User();
            $user->nom = "BAHBAH";
            $user->prenom = "SAAD";
            $user->email="sbahbah@myopla.com";
            $user->password=password_hash('password',PASSWORD_DEFAULT);
            $role = Role::where('name','agent')->first();
            $user->assignRole($role);
            $user->save();
        }
        else {
           $user= User::where('email','sbahbah@myopla.com')->first();
           $model_role= DB::table('model_has_roles')->where('model_id',$user->id)->update(['role_id' => 6]);   
        }
        //
        if(!Agent::where('email','sbahbah@myopla.com')->first()){
            $agent= new Agent();
            $agent->nom="BAHBAH";
            $agent->prenom="SAAD";
            $agent->email="sbahbah@myopla.com";
            $agent->service_id="62";
            $agent->save();
        }
        if(!User::where('email','sbahbah@myopla.com')->first()){
            $user = new User();
            $user->nom = "BAHBAH";
            $user->prenom = "SAAD";
            $user->email="sbahbah@myopla.com";
            $user->password=password_hash('password',PASSWORD_DEFAULT);
            $role = Role::where('name','agent')->first();
            $user->assignRole($role);
            $user->save();
        }
        else {
           $user= User::where('email','sbahbah@myopla.com')->first();
           $model_role= DB::table('model_has_roles')->where('model_id',$user->id)->update(['role_id' => 6]);   
        }


    }
    public function moveAgents(){
        $users = User::all();
        foreach($users as $user){
            if(Agent::where('email',$user->email)->first()){
                $model_role= DB::table('model_has_roles')->where('model_id',$user->id)->update(['role_id' => 6]);  
            }
        }
    }

}
