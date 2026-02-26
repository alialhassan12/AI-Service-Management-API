<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'price',
        'request_limit',
        'duration_days'
    ];

    //Relations
    public function subscriptionRequests(){
        return $this->hasMany(SubscriptionRequest::class);
    }
    public function subscriptions(){
        return $this->hasMany(Subscription::class);
    }
}
