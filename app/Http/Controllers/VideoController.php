<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use YouTube\YouTubeDownloader;
use App\Models\Activite;
use Illuminate\Support\Facades\Storage;
use YouTube\Exception\YouTubeException;
use Response;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video ::all();
        if(count($videos)==0) return 'nodatafound';
        foreach($videos as $video){
            $data[]=[
                 'id'=>$video->activite->id,
                 'activite'=>$video->activite->nom,
                 'image_url'=>($video->activite->image_url ==null)? '' : asset(\Storage::url($video->activite->image_url)),
            ];
        }
        $data = $this->my_array_unique($data);
        return $data;
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

        $user = Auth::user();
        if($request->ytp_url == null ){
            $video = new Video;
            $video->nom = $request->nom;
            $video->user_id = $user->id;
            $video->service_id = $request->serviceId;
            $video->activite_id = $request->activiteId;
            $fileName = $request->input('nom').'_'.time().'.'.$request->file->extension();
            $path = $request->file('file')->storeAs('uploads/resources/videos/desktop', $fileName, 'public');
            $video->url = $path;
            $video->save();
        }
        else {
            $youtube = new YouTubeDownloader();
            $downloadOptions = $youtube->getDownloadLinks($request->ytp_url);
            $filename = $request->input('nom').'_'.time().'.mp4';
           
            $url = "";
            $url= $downloadOptions->getFirstCombinedFormat()->url;

            $data =  file_get_contents($url);
      //  $data->storeAs('uploads/resources/videos/youtub', $fileName, 'public');
         $path= Storage::put('/public/uploads/resources/videos/youtub/'.$filename, $data , 'public');
           
    
            $video = new Video;
            $video->nom = $request->nom;
            $video->user_id = $user->id;
            $video->service_id = $request->serviceId;
            $video->activite_id = $request->activiteId;
            $video->url = 'uploads/resources/videos/youtub/'.$filename;
            $video->save();
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

       
        $videos = Video ::where('activite_id',$id)->get();
        return $videos;
    }
    public function show2($id)
    {
        $video = Video ::find($id);
     $url =asset(\Storage::url($video->url));



     
        $data=[
            'video'=>$video,
            'url'=>$url
        ];

     return json_encode($data);
   




    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        //
    }
    function my_array_unique($array, $keep_key_assoc = false){
        $duplicate_keys = array();
        $tmp = array();       
        foreach ($array as $key => $val){
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
