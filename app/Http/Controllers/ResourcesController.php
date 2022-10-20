<?php

namespace App\Http\Controllers;

use App\Models\Resources;
use App\Models\Activite ;
use App\Models\AgentVague;
use App\Models\Vague;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;
class ResourcesController extends Controller
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
      
       if($user->getRoleNames()[0] == 'client' ){
        foreach( $user->activite as $activitie ) {
            $Resources= Resources::where('activite_id',$activitie->id)->get();
        }

        }
       
        else {
            $Resources = Resources::all();
         
        }
        foreach($Resources as $fi){
            $data[]=[
                'id'=>$fi->activite->id,
                 'activite'=>$fi->activite->nom,
                 'image_url'=>($fi->activite->image_url ==null)? '' : asset(\Storage::url($fi->activite->image_url)),
            ];
      
        
        }
  
    
        if(count($data)===0) return 'nodatafound';
       return $this->my_array_unique($data);
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

        public function store(Request $request){
            
        
            $user = Auth::user();
            $resource = new Resources();
            $resource->nom = $request->nom;
            $resource->activite_id = $request->activiteId;
            $resource->service_id = $request->serviceId;
            $resource->user_id = $user->id;
            $fileName = $request->input('nom').'_'.time().'.'.$request->file->extension();
            $path = $request->file('file')->storeAs('uploads/resources', $fileName, 'public');
            $resource->url = $path;
            // if($request->type=='fi'){
            //     $resource->formation_i_id=$request->formation;
            // }
            // else {
            //     $resource->formation_c_id=$request->formation;
            // }
            $resource->save();
    
            return 'added';
        }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resources  $resources
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
       
        $resources = Resources::where('activite_id',$id)->get();
        if(count($resources)==0) return 'nodata';
        foreach($resources as $resource){
            $data[]=[
               'id'=>$resource->id,
               'nom'=>$resource->nom,
               'activite'=>$resource->activite->nom,
               'service'=>$resource->service->nom,

            ];
        }
       
        return $data;

       
     
    }
    public function show2( $id)
    {
        $resource = Resources::find($id);
        $pdf = Storage::disk('public')->get($resource->url);
        $data['resource'] = $resource;
        $data['pdf'] = base64_encode($pdf);
        return $data;
     
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resources  $resources
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resources  $resources
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resources $resources)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resources  $resources
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $resource = Resources::find($id);
        Storage::url($resource->url);
        $resource->delete();
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
    public function get2($id){
     
        $resource = Resources::find($id);
        $data = [
            'nom'=>$resource->nom,
            'service'=>$resource->service,
            'activite'=>$resource->activite,
        ];
        return $data ;
    }
    public function edit(Request $request){
     
        $resource = Resources::find($request->id);
        $resource->nom = $request->nom ;
        $resource->activite_id = $request->activite['id'];
        $resource->service_id = $request->service ;
         $resource->save() ;
    }
}
