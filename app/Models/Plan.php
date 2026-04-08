<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'service_id',
        'price',
        'request_limit',
        'duration_days',
        'is_active'
    ];

    //Relations
    public function subscriptionRequests(){
        return $this->hasMany(SubscriptionRequest::class);
    }
    public function subscriptions(){
        return $this->hasMany(Subscription::class);
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }
}
