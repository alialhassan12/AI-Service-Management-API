<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

use function Symfony\Component\Clock\now;

class subscriptionsController extends Controller
{
    public function submitSubscriptionRequest(Request $request){
        $request->validate([
            'user_id'=>'required|integer',
            'plan_id'=>'required|integer'
        ]);
        $newRequest=SubscriptionRequest::create([
            'user_id'=>$request->user_id,
            'plan_id'=>$request->plan_id,
        ]);
        return response()->json([
            'message'=>"Subscription request sent",
            'subscriptionReq'=>$newRequest
        ],201);
    }

    public function showPendingRequests(){
        $requests=SubscriptionRequest::where('status','pending')->get();
        return response()->json([
            'message'=>"pending requests",
            "requests"=>$requests
        ]);
    }

    public function approveRequests(Request $request,$id){
        $req=SubscriptionRequest::where('id',$id)->with('plan')->first();
        if(!$req){
            return response()->json([
                'message'=>'request not found'
            ],404);
        }
        if($req->status == 'approved'){
            return response()->json([
                'message'=>'request already approved'
            ],400);
        }
        
        //get active subs
        $subscription=Subscription::where('user_id',$req->user_id)
                                    ->where('status','active')
                                    ->where('ends_at','>',now())
                                    ->first();
        
        $startsAtDate=Carbon::now();

        if($subscription){
            if($req->plan_id==$subscription->plan_id){
                $subscription->ends_at=$subscription->ends_at->addDays($req->plan->duration_days);
            }else{
                $subscription->plan_id=$req->plan_id;
                $subscription->starts_at=$startsAtDate;
                $subscription->ends_at=$startsAtDate->copy()->addDays($req->plan->duration_days);
            }
            $subscription->save();
        }else{
            $subscription=Subscription::create([
            'user_id'=>$req->user_id,
            'plan_id'=>$req->plan_id,
            'starts_at'=>$startsAtDate,
            'ends_at'=>$startsAtDate->copy()->addDays($req->plan->duration_days)
        ]);
        }

        $req->status='approved';
        $req->save();

        return response()->json([
            'message'=>'request approved',
            'subscription'=>$subscription
        ],200);

    }

    public function rejectRequests(Request $request,$id){
        $req=SubscriptionRequest::where('id',$id)->first();
        if(!$req){
            return response()->json([
                'message'=>'request not found'
            ],404);
        }
        if($req->status == 'rejected'){
            return response()->json([
                'message'=>'request already rejected'
            ],400);
        }
        $req->status='rejected';
        $req->save();
        return response()->json([
            'message'=>'request rejected'
        ],200);
    }
    
}
