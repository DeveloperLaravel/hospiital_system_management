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

        // Create permissions for appointments
        $appointmentPermissions = [
            'appointments-view',
            'appointments-create',
            'appointments-edit',
            'appointments-delete',
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
            // Appointments
            'appointments-view',
            'appointments-create',
            'appointments-edit',
            'appointments-delete',
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
            // Appointments
            'appointments-view',
            'appointments-create',
            'appointments-edit',
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
            // Appointments
            'appointments-view',
            'appointments-create',
            'appointments-edit',
            // Patients
            'patients-view',
            'patients-create',
            // Rooms
            'rooms-view',
        ]);

        // Nurse role
        $nurseRole = Role::firstOrCreate(['name' => 'Nurse', 'guard_name' => 'web']);
        $nurseRole->givePermissionTo([
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
