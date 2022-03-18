<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PersonTrustResource;
use App\PersonTrust;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonTrustController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPerson(Request $request)
    {
        try {
            $user_id = $request->user()->id;

            $personTrust = PersonTrust::where('user_id', '=', $user_id)->get();
            return  PersonTrustResource::collection($personTrust);
        } catch (\Throwable $th) {
            return response()->json([
                'fail' => $th
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'phoneNumber' => 'required|string',
            'imageProfil' => 'string',
            'user_id' => 'exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'fail' => $validator->errors(),
            ], 422);
        }
        try {
            $data = $request->all();
            PersonTrust::create($data);

            return response()->json([
                'success' => "created successfully"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'fail' => $th
            ], 402);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
