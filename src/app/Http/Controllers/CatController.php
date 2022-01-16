<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cat;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', Cat::class);

        // do "index" is not allowed.
        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Cat::class);

        return Cat::create(
            [
                "name" => $request->input("name"),
                "birth" => new Carbon($request->input("birth")),
                "description" => $request->input("description"),
                "user_id" => Auth::id(),
            ],
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cat $cat)
    {
        $this->authorize('view', $cat);

        return Cat::find($cat->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cat $cat)
    {
        $this->authorize('update', $cat);

        $status = $cat->update([
            "name" => $request->input("name"),
            "birth" => new Carbon($request->input("birth")),
            "description" => $request->input("description"),
            "user_id" => Auth::id(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cat $cat)
    {
        $this->authorize('delete', $cat);

        $cat->delete();
    }
}
