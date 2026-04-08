<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class plansController extends Controller
{
    public function createPlan(Request $request)
    {
        $request->validate([
            'service_id'=>"required|exists:services,id",
            "name" => "required",
            "price" => "required|numeric|min:0|decimal:0,2",
            "request_limit" => "required|numeric",
            "duration_days" => "required|numeric"
        ]);
        $plan = Plan::create([
            'name' => $request->name,
            'service_id'=>$request->service_id,
            'price' => $request->price,
            'request_limit' => $request->request_limit,
            'duration_days' => $request->duration_days
        ]);
        return response()->json([
            'message' => 'Plan created successfully',
            'plan' => $plan
        ], 201);
    }

    public function getAllPlans(Request $request)
    {
        $allPlans = Plan::all()->toArray();
        return response()->json([
            'message' => "read all plans",
            'plans' => $allPlans
        ], 200);
    }

    public function updatePlan(Request $request,$id){
        $plan=Plan::whereId($id)->first();
        if(!$plan){
            return response()->json([
                'message'=>'no plan found'
            ],404);
        }

        $request->validate([
            "name" => "required",
            "price" => "required|numeric|min:0|decimal:0,2",
            "request_limit" => "required|numeric",
            "duration_days" => "required|numeric"
        ]);
        
        $plan->name=$request->name;
        $plan->price=$request->price;
        $plan->request_limit=$request->request_limit;
        $plan->duration_days=$request->duration_days;
        $plan->save();

        return response()->json([
            'message'=>'plan updated successfully',
            'plan'=>$plan
        ],200);
    }

    public function deletePlan(Request $request,$id){
        $plan=Plan::whereId($id)->first();
        if(!$plan){
            return response()->json([
                'message'=>'no plan found'
            ],404);
        }
        $plan->delete();

        return response()->json([
            'message'=>'plan deleted successfully'
        ],200);
    }
    public function activatePlan(Request $request,$id){
        $plan=Plan::whereId($id)->first();
        if(!$plan){
            return response()->json([
                'message'=>'plan not found'
            ],404);
        }
        $plan->is_active=true;
        $plan->save();

        return response()->json([
            'message'=>"{$plan->name} plan activated"
        ]);
    }
    public function deactivatePlan(Request $request,$id){
        $plan=Plan::whereId($id)->first();
        if(!$plan){
            return response()->json([
                'message'=>'plan not found'
            ],404);
        }
        $plan->is_active=false;
        $plan->save();

        return response()->json([
            'message'=>"{$plan->name} plan deactivated"
        ]);
    }
}
