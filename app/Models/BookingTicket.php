<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BookingTicket extends Model
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
    }
    public function airplane()
    {
        return $this->belongsTo(Airplane::class);
    }

    public function transit_steps()
    {
        return $this->hasMany(BookingTicket::class,'ticket_id','id')->where('is_transit_step','1');
    }
    public function go_transit_steps()
    {
        return $this->hasMany(BookingTicket::class,'ticket_id','id')->where('is_transit_step','1')
        ->where('transit_step_type','going');
    }
    public function return_transit_steps()
    {
        return $this->hasMany(BookingTicket::class,'ticket_id','id')->where('is_transit_step','1')
        ->where('transit_step_type','return');
    }
    
    public function get_country($id)
    {
        return Country::find($id);
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
}
