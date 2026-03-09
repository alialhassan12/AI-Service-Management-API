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

    public function getServices(Request $request){
        $services=Service::with('plans')->get();
        return response()->json([
            'message'=>'all services',
            'services'=>$services
        ],200);
    }
    
    public function updateService(Request $request){
        $request->validate([
            'name'=>'required',
            'description'=>'required'
        ]);
        $service=Service::where('id',$request->id)->first();
        if(!$service){
            return response()->json([
                'message'=>'Service not Found'
            ],404);
        }
        $service->name=$request->name;
        $service->description=$request->description;
        $service->save();

        return response()->json([
            'message'=>'Service updated successfully',
            'service'=>$service
        ],200);
    }

    public function deleteService(Request $request){
        $service=Service::where('id',$request->id)->first();
        if(!$service){
            return response()->json([
                'message'=>'Service not Found'
            ],404);
        }
        $service->delete();

        return response()->json([
            'message'=>'Service deleted successfully'
        ],200);
    }
}
