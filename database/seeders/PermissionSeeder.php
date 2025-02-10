<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;



class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Modules that require actions
        $modulesWithActions = [
            'role',
            'employee',
            'customer',
            'country',
            'airplane',
            'booking',
            'task',
            'setting',
            'company',
            'hotel',
        ];

        // Modules without actions
        $modulesWithoutActions = [
            'home-client',
            'home-pendingBooking',
            'home-completedBooking',
            'home-bookingThisMonth',
            'home-bookingLastMonth',
            'home-totalSelling',
            'home-totalRevenue',
        ];

        // Create permissions for modules with actions
        foreach ($modulesWithActions as $module) {
            $actions = ['table', 'add', 'edit', 'delete'];
            foreach ($actions as $action) {
                Permission::create([
                    'name' => "$module-$action",
                    'guard_name' => 'admin',
                ]);
            }
        }

        // Create permissions for modules without actions
        foreach ($modulesWithoutActions as $module) {
            Permission::create([
                'name' => $module,
                'guard_name' => 'admin',
            ]);
        }
    }
}
