<?php

namespace App\Http\Controllers;

use App\Models\ancienfi;
use App\Http\Requests\StoreancienfiRequest;
use App\Http\Requests\UpdateancienfiRequest;

class AncienfiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ancienfis = ancienfi::all();
        return $ancienfis;
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
     * @param  \App\Http\Requests\StoreancienfiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreancienfiRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ancienfi  $ancienfi
     * @return \Illuminate\Http\Response
     */
    public function show(ancienfi $ancienfi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ancienfi  $ancienfi
     * @return \Illuminate\Http\Response
     */
    public function edit(ancienfi $ancienfi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateancienfiRequest  $request
     * @param  \App\Models\ancienfi  $ancienfi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateancienfiRequest $request, ancienfi $ancienfi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ancienfi  $ancienfi
     * @return \Illuminate\Http\Response
     */
    public function destroy(ancienfi $ancienfi)
    {
        //
    }
}
