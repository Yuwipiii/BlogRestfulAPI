<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        if(!Gate::allows('is_admin')){
            return response()->json(['message'=>'Permission Denied'],403,);
        }
        return response()->json(User::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        if(!Gate::allows('is_admin')){
            return response()->json(['message'=>'Permission Denied'],403);
        }
        $user = User::all()->find($id);
        if($user == null){
            return response()->json(['message'=>'User not found'],404);
        }
        return response()->json([$user->toArray()],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        if(!Gate::allows('is_admin')){
            return response()->json(['message'=>'Permission Denied'],403);
        }
        $user = User::all()->find($id);
        if($user == null){
            return response()->json(['message'=>'User not found'],404);
        }
        $user->delete();
        return response()->json(['message'=>'User successfully delete'],200);
    }
}
