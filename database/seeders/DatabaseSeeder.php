<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\Company;
use App\Models\Hotel;
use App\Models\AirPlane;
use App\Models\User;
use App\Models\Booking;
use App\Models\BookingUser;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        Company::Create(
            ['name' => 'Droub'],
            ['name' => 'DahabTours'],
            ['name' => 'GoTravel'],
        );
        Hotel::Create(
            ['name' => 'SeaView'],
            ['name' => 'Discovery'],
            ['name' => 'BlackSwan'],
        );
        AirPlane::Create(
            ['name' => 'FlightEgypt'],
            ['name' => 'FlightChina'],
            ['name' => 'FlightEmirates'],
        );
        User::Create([
            'name'    => 'Noor Ali',
            'email'   => 'user@example1.com',
            'phone'   => 99612345671,
            'address' => 'address 1',
            'date_of_birth'        => '2010/12/6',
            'date_of_passport_end' => '2026/12/8',
            'family_id' => 1,
        ]);
        User::Create([
            'name'    => 'Ali walid ali',
            'email'   => 'user@example2.com',
            'phone'   => 99612345672,
            'address' => 'address 2',
            'date_of_birth'        => '2011/12/7',
            'date_of_passport_end' => '2020/12/2',
            'family_id' => 2,
        ]);
        User::Create([
            'name'    => 'محمد نافع سعيد احمد',
            'email'   => 'user@example3.com',
            'phone'   => 99612345673,
            'address' => 'address 3',
            'date_of_birth'        => '1991/12/12',
            'date_of_passport_end' => '2025/12/21',
            'family_id' => 2,
        ]);
        User::Create([
            'name'    => 'ليلي إبراهيم عمر سالم',
            'email'   => 'user@example4.com',
            'phone'   => 99612345674,
            'address' => 'address 4',
            'date_of_birth'        => '1991/12/3',
            'date_of_passport_end' => '2011/12/12',
            'family_id' => 4,
        ]);
        User::Create([
            'name'    => 'noha ali walid ali',
            'email'   => 'user@example5.com',
            'phone'   => 99612345675,
            'address' => 'address 5',
            'date_of_birth'        => '1991/12/6',
            'date_of_passport_end' => '2027/12/7',
            'family_id' => 3,
        ]);
        User::Create([
            'name'    => 'salma ali walid ali',
            'email'   => 'user@example6.com',
            'phone'   => 99612345676,
            'address' => 'address 6',
            'date_of_birth'        => '1991/12/13',
            'date_of_passport_end' => '2026/12/1',
            'family_id' => 3,
        ]);
        User::Create([
            'name'    => 'omar ali walid ali',
            'email'   => 'user@example7.com',
            'phone'   => 99612345677,
            'address' => 'address 7',
            'date_of_birth'        => '1991/12/2',
            'date_of_passport_end' => '2028/12/6',
            'family_id' => 3,
        ]);
        User::Create([
            'name'    => 'omar mostafa walid ali',
            'email'   => 'user@example8.com',
            'phone'   => 99612345678,
            'address' => 'address 8',
            'date_of_birth'        => '1991/12/5',
            'date_of_passport_end' => '2026/12/8',
            'family_id' => 4,
        ]);
        User::Create([
            'name'    => 'omar mostafa walid ali',
            'email'   => 'user@example9.com',
            'phone'   => 99612345679,
            'address' => 'address 9',
            'date_of_birth'        => '1991/12/29',
            'date_of_passport_end' => '2025/12/9',
            'family_id' => 4,
        ]);
        Booking::Create([
            'user_id'    => 3,
        ]);
        BookingUser::Create([
            'booking_id' => 1,
            'user_id'    => 7,
        ]);
        BookingUser::Create([
            'booking_id' => 1,
            'user_id'    => 8,
        ]);
        Booking::Create([
            'user_id'    => 2,
        ]);
        BookingUser::Create([
            'booking_id' => 2,
            'user_id'    => 1,
        ]);
    }
}
