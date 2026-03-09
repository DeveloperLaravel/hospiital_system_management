<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for shifts
        $shiftPermissions = [
            'shifts-view',
            'shifts-create',
            'shifts-edit',
            'shifts-delete',
        ];

        foreach ($shiftPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create permissions for appointments
        $appointmentPermissions = [
            'appointments-view',
            'appointments-view-all',
            'appointments-create',
            'appointments-edit',
            'appointments-delete',
            'appointments-confirm',
            'appointments-complete',
            'appointments-cancel',
            'appointments-export',
        ];

        foreach ($appointmentPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create permissions for other modules
        $permissions = [
            // Users permissions
            'users-view',
            'users-create',
            'users-edit',
            'users-delete',
            // Roles permissions
            'roles-view',
            'roles-create',
            'roles-edit',
            'roles-delete',
            // Permissions permissions
            'permissions-view',
            'permissions-create',
            'permissions-edit',
            'permissions-delete',
            // Patients permissions
            'patients-view',
            'patients-create',
            'patients-edit',
            'patients-delete',
            // Doctors permissions
            'doctors-view',
            'doctors-create',
            'doctors-edit',
            'doctors-delete',
            // Departments permissions
            'departments-view',
            'departments-create',
            'departments-edit',
            'departments-delete',
            // Medical Records permissions
            'medical-records-view',
            'medical-records-create',
            'medical-records-edit',
            'medical-records-delete',
            // Prescriptions permissions
            'prescriptions-view',
            'prescriptions-create',
            'prescriptions-edit',
            'prescriptions-delete',
            // Rooms permissions
            'rooms-view',
            'rooms-create',
            'rooms-edit',
            'rooms-delete',
            // Medications permissions
            'medications-view',
            'medications-create',
            'medications-edit',
            'medications-delete',
            // Invoices permissions
            'invoices-view',
            'invoices-create',
            'invoices-edit',
            'invoices-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions

        // Admin role - gets all permissions
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo(Permission::all());

        // Supervisor role
        $supervisorRole = Role::firstOrCreate(['name' => 'Supervisor', 'guard_name' => 'web']);
        $supervisorRole->givePermissionTo([
            // Shifts
            'shifts-view',
            'shifts-create',
            'shifts-edit',
            'shifts-delete',
            // Appointments - Full access with granular permissions
            'appointments-view',
            'appointments-view-all',
            'appointments-create',
            'appointments-edit',
            'appointments-delete',
            'appointments-confirm',
            'appointments-complete',
            'appointments-cancel',
            'appointments-export',
            // Patients
            'patients-view',
            'patients-create',
            'patients-edit',
            // Doctors
            'doctors-view',
            // Departments
            'departments-view',
            'departments-create',
            'departments-edit',
            'departments-delete',
            // Medical Records
            'medical-records-view',
            'medical-records-create',
            'medical-records-edit',
            // Prescriptions
            'prescriptions-view',
            'prescriptions-create',
            'prescriptions-edit',
            // Rooms
            'rooms-view',
            'rooms-create',
            'rooms-edit',
            // Medications
            'medications-view',
            'medications-create',
            'medications-edit',
        ]);

        // Doctor role
        $doctorRole = Role::firstOrCreate(['name' => 'Doctor', 'guard_name' => 'web']);
        $doctorRole->givePermissionTo([
            // Shifts
            'shifts-view',
            'shifts-edit',
            // Appointments - Can view own, create, edit own, confirm, complete
            'appointments-view',
            'appointments-create',
            'appointments-edit',
            'appointments-confirm',
            'appointments-complete',
            // Patients
            'patients-view',
            // Medical Records
            'medical-records-view',
            'medical-records-create',
            'medical-records-edit',
            // Prescriptions
            'prescriptions-view',
            'prescriptions-create',
            'prescriptions-edit',
            // Medications
            'medications-view',
        ]);

        // Receptionist role
        $receptionistRole = Role::firstOrCreate(['name' => 'Receptionist', 'guard_name' => 'web']);
        $receptionistRole->givePermissionTo([
            // Appointments - Can view all, create, edit, confirm
            'appointments-view',
            'appointments-view-all',
            'appointments-create',
            'appointments-edit',
            'appointments-confirm',
            // Patients
            'patients-view',
            'patients-create',
            // Rooms
            'rooms-view',
        ]);

        // Nurse role
        $nurseRole = Role::firstOrCreate(['name' => 'Nurse', 'guard_name' => 'web']);
        $nurseRole->givePermissionTo([
            // Shifts
            'shifts-view',
            'shifts-edit',
            // Appointments - Can view all, complete
            'appointments-view',
            'appointments-complete',
            // Patients
            'patients-view',
            // Medical Records
            'medical-records-view',
            // Medications
            'medications-view',
            'medications-edit',
        ]);

        $this->command->info('Roles and permissions seeded successfully!');
        $this->command->info('Created roles: Admin, Supervisor, Doctor, Receptionist, Nurse');
        $this->command->info('Created permissions for appointments and other modules');
    }
}
