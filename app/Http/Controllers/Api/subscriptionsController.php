<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\approvalMail;
use App\Mail\rejectedMail;
use App\Mail\submitSubscriptionRequest;
use App\Models\Subscription;
use App\Models\SubscriptionRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

use function Symfony\Component\Clock\now;

class subscriptionsController extends Controller
{
    public function submitSubscriptionRequest(Request $request){
        $request->validate([
            'plan_id'=>'required|integer'
        ]);
        $user=auth('sanctum')->user();
        $newRequest=SubscriptionRequest::create([
            'user_id'=>$user->id,
            'plan_id'=>$request->plan_id,
        ]);
        Mail::to($user->email)->send(new submitSubscriptionRequest($newRequest));
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
        $req=SubscriptionRequest::where('id',$id)->with('plan','user')->first();
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
        
        //get active subscription if available
        $subscription=Subscription::where('user_id',$req->user_id)
                                    ->where('status','active')
                                    ->where('ends_at','>',now())
                                    ->first();
        
        $startsAtDate=Carbon::now();
        
        //if user has active subscription
        if($subscription){
            //if user wants to renew the same plan
            if($req->plan_id==$subscription->plan_id){
                //extend the subscription
                $subscription->ends_at=$subscription->ends_at->addDays($req->plan->duration_days);
            }else{
                //update the subscription
                $subscription->plan_id=$req->plan_id;
                $subscription->starts_at=$startsAtDate;
                $subscription->ends_at=$startsAtDate->copy()->addDays($req->plan->duration_days);
            }
            // reset request limit
            $subscription->request_limit=0;
            $subscription->save();
        }else{
            //if no active subscription create new subscription
            $subscription=Subscription::create([
                'user_id'=>$req->user_id,
                'plan_id'=>$req->plan_id,
                'starts_at'=>$startsAtDate,
                'ends_at'=>$startsAtDate->copy()->addDays($req->plan->duration_days)
            ]);
        }

        $req->status='approved';
        $req->save();

        Mail::to($req->user->email)->send(new approvalMail($subscription));
        
        return response()->json([
            'message'=>'request approved',
            'subscription'=>$subscription
        ],200);

    }

    public function rejectRequests(Request $request,$id){
        $req=SubscriptionRequest::where('id',$id)->with('user')->first();
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

        Mail::to($req->user->email)->send(new rejectedMail($req->user));

        return response()->json([
            'message'=>'request rejected'
        ],200);
    }
    
}
