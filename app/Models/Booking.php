<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function booking_users()
    {
        return $this->belongsToMany(User::class, 'booking_users', 'booking_id', 'user_id');
    }
    public function user_can_edit()
    {
        $user      = Auth::guard('admin')?->user();
        $isSuper   = $user?->is_super;
        $isCreator = (!$this->created_by || $this->created_by == $user?->id);
        return ($user?->is_super || $isCreator);
    }
    public function user_can_cancel()
    {
        $notCompleted = ($this->status != 'completed');
        $isPending = ($this->status == 'pending');
        $isSuper = Auth::guard('admin')?->user()?->is_super;
        return ($notCompleted && ($isSuper || $isPending));
    }
    public function user_can_retuen_to_pending()
    {
        $notPending = ($this->status != 'pending');
        $isSuper = Auth::guard('admin')?->user()?->is_super;
        return ($notPending && $isSuper);
    }
    public function user_can_completed()
    {
        $isPending    = ($this->status == 'pending');
        $isSuper = Auth::guard('admin')?->user()?->is_super;
        return  ($isPending || ($isSuper || $isPending));
    }
    public function trips()
    {
        return $this->hasMany(BookingTrip::class);
    }
    public function visas()
    {
        return $this->hasMany(BookingVisa::class);
    }
    public function transports()
    {
        return $this->hasMany(BookingTransport::class);
    }
    public function tickets()
    {
        return $this->hasMany(BookingTicket::class)->where('is_transit_step','0');
    }
    public function hotels()
    {
        return $this->hasMany(BookingHotel::class);
    }
    public function total_prices()
    {
        $total_prices = (int)$this->trips?->sum('selling_price') + 
                        (int)$this->visas?->sum('selling_price') + 
                        (int)$this->transports?->sum('selling_price') + 
                        (int)$this->tickets?->sum('selling_price') + 
                        (int)$this->hotels?->sum('selling_price');
        return $total_prices;
    }
    public function airplane()
    {
        return $this->belongsTo(Airplane::class);
    }
    public function get_service_country()
    {
       return ($this->tickets->where('is_transit_step',0)?->first()?->get_country($this->tickets?->first()->to_country)?->name);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
   
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
   
    public function bookingPdfs()
    {
        return $this->hasMany(BookingDocument::class);
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
    }

}
