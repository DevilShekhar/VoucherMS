<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Roles
            'roles.index',
            'roles.create',
            'roles.store',
            'roles.show',
            'roles.edit',
            'roles.update',
            'roles.destroy',

            // Permissions
            'permissions.index',
            'permissions.create',
            'permissions.store',
            'permissions.edit',
            'permissions.update',
            'permissions.destroy',

            // Voucher Vendors
            'voucher-vendors.index',
            'voucher-vendors.create',
            'voucher-vendors.store',
            'voucher-vendors.show',
            'voucher-vendors.edit',
            'voucher-vendors.update',
            'voucher-vendors.destroy',

            // Users
            'users.index',
            'users.create',
            'users.store',
            'users.show',
            'users.edit',
            'users.update',
            'users.destroy',

            // Centers
            'centers.index',
            'centers.create',
            'centers.store',
            'centers.show',
            'centers.edit',
            'centers.update',
            'centers.destroy',

            // Courses
            'courses.index',
            'courses.create',
            'courses.store',
            'courses.show',
            'courses.edit',
            'courses.update',
            'courses.destroy',

            // Leads
            'leads.index',
            'leads.create',
            'leads.store',
            'leads.show',
            'leads.edit',
            'leads.update',
            'leads.destroy',
            'leads.followups.store',

            // Lead Notifications
            'lead.notifications',
            'lead.notifications.read',

            // Candidates
            'candidates.index',
            'candidates.create',
            'candidates.store',
            'candidates.show',
            'candidates.edit',
            'candidates.update',
            'candidates.destroy',

            // Payments
            'payments.index',
            'payments.create',
            'payments.store',
            'payments.show',

            // Vouchers
            'vouchers.index',
            'vouchers.create',
            'vouchers.store',
            'vouchers.show',
            'vouchers.edit',
            'vouchers.update',
            'vouchers.destroy',

            // Voucher Requests
            'voucher-requests.index',
            'voucher-requests.create',
            'voucher-requests.store',
            'voucher-requests.show',
            'voucher-requests.edit',
            'voucher-requests.update',
            'voucher-requests.destroy',
            'voucher-requests.approve.admin',
            'voucher-requests.approve.superadmin',
            'voucher-requests.reject',
            'voucher-requests.approve',
            'voucher-requests.allocate',

            // Voucher Request Notifications
            'voucher-request-notifications.latest',
            'voucher-request-notifications.read',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Optional: Clear cache again
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
