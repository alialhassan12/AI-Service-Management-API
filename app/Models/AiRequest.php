<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiRequest extends Model
{
    protected $fillable = [
        'user_id',
        'subscription_id',
        'service_id',
        'title',
        'description',
        'status',
        'admin_notes'
    ];

    //Relations
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function subscription(){
        return $this->belongsTo(Subscription::class);
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }
}
