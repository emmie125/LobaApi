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
    public function index(Request $request)
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
        $user_id = $request->user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'phoneNumber' => 'required|string',
            'imageProfil' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'fail' => $validator->errors(),
            ], 422);
        }
        try {
            $data = $request->all();
            PersonTrust::create($data, ['user_id' => $user_id]);

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
        $user_id = $request->user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'phoneNumber' => 'required|string',
            'imageProfil' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'fail' => $validator->errors(),
            ], 422);
        }
        try {
            $data = $request->all();
            PersonTrust::where('id', $data['id'])->update([
                'name' => $data['name'],
                'phoneNumber' => $data['phoneNumber'],
                'imageProfil' => $data['imageProfil'],
            ]);

            return response()->json([
                'success' => "updated successfully"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'fail' => $th
            ], 402);
        }
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
