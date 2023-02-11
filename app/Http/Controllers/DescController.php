<?php

namespace App\Http\Controllers;

use App\Http\Resources\DeskResource;
use App\Models\Desc;
use Illuminate\Http\Request;

class DescController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
//        /**
//         * @return \Illuminate\Http\Response
//         */

        $desks = Desc::paginate();

        return DeskResource::collection($desks);
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
     * @param  \App\Models\Desc  $desc
     * @return \Illuminate\Http\Response
     */
    public function show(Desc $desc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Desc  $desc
     * @return \Illuminate\Http\Response
     */
    public function edit(Desc $desc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Desc  $desc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Desc $desc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Desc  $desc
     * @return \Illuminate\Http\Response
     */
    public function destroy(Desc $desc)
    {
        //
    }
}
