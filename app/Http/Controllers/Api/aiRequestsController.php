<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AiRequest;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Psr\Http\Message\ResponseInterface;

use function Symfony\Component\Clock\now;

class aiRequestsController extends Controller
{
    public function submitAiRequests(Request $request){
        
        $request->validate([
            'title'=>'required',
            'description'=>'required'
        ]);

        $user=auth('sanctum')->user();
        //check if user have active subscription
        $subscription=Subscription::where('user_id',$user->id)
                                ->where('status','active')
                                ->where('ends_at','>',now())
                                ->with('plan')
                                ->first();
        if(!$subscription){
            return response()->json([
                'message'=>'No active subscription found'
            ],403);
        }
        //check for ai requests limit
        $plan=$subscription->plan;
        $aiRequestCount=AiRequest::where('subscription_id',$subscription->id)->count();
        if($aiRequestCount>=$plan->request_limit){
            return response()->json([
                'message'=>'Request Limit Reached'
            ],403);
        }

        //after checking create ai request
        $newAiRequest=AiRequest::create([
            'user_id'=>$user->id,
            'subscription_id'=>$subscription->id,
            'service_id'=>$plan->service_id,
            'title'=>$request->title,
            'description'=>$request->description
        ]);

        return response()->json([
            'message'=>'Ai request sent successfully',
            'aiRequest'=>$newAiRequest
        ]);
    }

    public function aiRequestHistory(Request $request){
        $user=auth('sanctum')->user();
        $aiRequestsHistory=AiRequest::where('user_id',$user->id)->get();
        return response()->json([
            'message'=>'Ai Requests history',
            'aiRequestsHistory'=>$aiRequestsHistory
        ],200);
    }

    public function getAllAiRequests(Request $request){
        //get all pending and processing ai-requests
        $requests=AiRequest::where('status',['pending','processing'])->get();
        return response()->json([
            'message'=>'Pending and Processing ai-requests',
            'aiRequests'=>$requests
        ],200);
    }
}
