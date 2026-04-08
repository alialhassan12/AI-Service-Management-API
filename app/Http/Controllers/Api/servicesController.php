<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Carbon\Carbon;
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
        $services=Service::with(['plans'=>function($query){
            $query->where('is_active',1);
        }])->get();

        return response()->json([
            'message'=>'all services',
            'services'=>$services
        ],200);
    }
    
    public function updateService(Request $request,$id){
        $request->validate([
            'name'=>'required',
            'description'=>'required'
        ]);
        $service=Service::where('id',$id)->first();
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

    public function deleteService(Request $request,$id){
        $service=Service::where('id',$id)->first();
        if(!$service){
            return response()->json([
                'message'=>'Service not Found'
            ],404);
        }
        // check for active subscriptions
        $activeSubscriptions=$service->subscriptions()->where('status','active')->where('ends_at','>',Carbon::now())->get();
        if($activeSubscriptions->count()>0){
            return response()->json([
                'message'=>'Service has active subscriptions'
            ],400);
        }
        // check for pending requests
        $pendingRequests=$service->subscriptionRequests()->where('status','pending')->get();
        if($pendingRequests->count()>0){
            return response()->json([
                'message'=>'Service has pending requests'
            ],400);
        }

        // delete service if no active subscriptions and no pending requests
        $service->delete();

        return response()->json([
            'message'=>'Service deleted successfully'
        ],200);
    }
}
