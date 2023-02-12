<?php

namespace App\Http\Controllers;

use App\Http\Resources\DeskResource;
use App\Models\Desk;
use App\Models\DeskList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $desks = Desk::with('deskLists')->paginate();

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
     * @return \Illuminate\Http\Response|DeskResource
     */
    public function store(Request $request)
    {
        $desk = new Desk($request->validate([
            'desk_name' => ['required', 'max:255'],
            'desk_description' => [],
        ]));

        $desk_created = $desk->save();

        if ($desk_created) {
            if (!empty($request['desk_lists'])) {
                foreach ($request['desk_lists'] as $desk_list_data) {
                    $desk_list = new DeskList(array_merge($desk_list_data, [
                        'desk_id' => $desk->id ?? null,
                        'item_description' => $desk_list_data['item_description'] ?? '',
                    ]));

                    $desk_list->save();
                }
            }

            /**
             * Get eloquent relations from database
             */
            return new DeskResource($desk->load('deskLists'));

//            return new DeskResource(Desk::where('id', $desk->id)->first()->load('deskLists'));
        } else {
            return response('An error occurred while processing request', 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Desk  $desk
     * @return DeskResource
     */
    public function show(Desk $desk)
    {
        return new DeskResource($desk);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Desk  $desk
     * @return DeskResource
     */
    public function edit(Desk $desk)
    {
        $desk = $desk->load('deskLists');

        return new DeskResource($desk);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Desk  $desk
     * @return DeskResource
     */
    public function update(Request $request, Desk $desk)
    {
        $desk->update($request->validate([
            'desk_name' => ['required', 'max:255'],
            'desk_description' => [],
        ]));

        return new DeskResource($desk);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Desk  $desk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Desk $desk)
    {
        $desk->delete();

        return response('', 204);
    }
}
