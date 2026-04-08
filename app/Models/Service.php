<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    //Relations
    public function aiRequests(){
        return $this->hasMany(AiRequest::class);
    }
    public function plans(){
        return $this->hasMany(Plan::class);
    }
    public function subscriptions(){
        return $this->hasManyThrough(Subscription::class,Plan::class);
    }
    public function subscriptionRequests(){
        return $this->hasManyThrough(SubscriptionRequest::class,Plan::class);
    }
}
