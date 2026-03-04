<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class servicesController extends Controller
{
    public function createService(Request $request){
        $request->validate([
            'name'=>'required',
            'description'=>'required'
        ]);
        $service=Service::create([
            'name'=>$request->name,
            'description'=>$request->description
        ]);

        return response()->json([
            'message'=>'service created successfully',
            'service'=>$service
        ]);
    }
}
