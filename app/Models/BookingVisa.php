<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BookingVisa extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $userId = Auth::id();
            $model->created_by = $userId;
            $model->updated_by = $userId;
        });

        static::updating(function ($model) {
            $userId = Auth::id();
            $model->updated_by = $userId;
        });
        // static::updated(function ($model) {
        //     Booking::where('id',$model->booking_id)->update(['total_selling_price' => $model->booking->total_prices()]);
        // });
    }

}
