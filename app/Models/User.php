<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;



class User extends Authenticatable
{
   use HasApiTokens, HasFactory, Notifiable;

   /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
   protected $guarded = [];

   /**
    * The attributes that should be hidden for serialization.
    *
    * @var array<int, string>
    */
   protected $hidden = [
      'password',
      'remember_token',
   ];

   public function companies()
    {
        return $this->belongsToMany(Company::class, 'user_companies', 'user_id', 'company_id')
                    ->withTimestamps(); // Include timestamps if the pivot table has them
    }
    // public function bookings()
    // {
    //     return $this->belongsToMany(Booking::class, 'booking_users', 'user_id', 'booking_id');
    // }

    public function user_bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_users', 'user_id', 'booking_id');
    }

   public function countries()
   {
       return $this->hasMany(Country::class);
   }

   public function getBrothers(User $user)
   {
       return User::where('family_id', $user->family_id)->where('id', '!=', $user->id)->get();
   }

}
