<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionRequest extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'status'
    ];

    //Relations
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function  plan(){
        return $this->belongsTo(Plan::class);
    }
}
