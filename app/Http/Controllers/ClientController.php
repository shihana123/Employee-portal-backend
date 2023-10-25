<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'client_name' => 'required',
            'company_name' => 'required',
            'email' => 'required|email',
            'mobile_no' => 'required|numeric',
            'address' => 'required',
            'status' => 'required'
        ]);
        if (Client::where('email', $request->email)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'The email id already exists',
            ], 401);
        }
        $user_data = [
            'client_id' => $request->client_id,
            'client_name' => $request->client_name,
            'company_name' => $request->company_name,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'address' => $request->address,
            'status' => $request->status
        ];
        if($client = Client::create($user_data))
        {
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully Created one Client',
            ]);
        }
        else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
