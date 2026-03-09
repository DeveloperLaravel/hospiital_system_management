# TODO - AppointmentManager Permissions Enhancement

## Task
Add granular permissions and role-based filtering to AppointmentManager.php professionally

## Steps:
1. [x] Add new granular permissions to RolesAndPermissionsSeeder.php
   - appointments-confirm
   - appointments-complete
   - appointments-cancel
   - appointments-view-all
   - appointments-export

2. [x] Enhance AppointmentManager.php with:
   - More granular permission methods
   - Role-based data filtering (doctors see only their appointments)
   - Enhanced permission logic with business rules
   - Better Arabic error messages

3. [x] Update appointment-manager.blade.php view with enhanced permission UI

## Notes:
- Admin sees all appointments
- Supervisors see all appointments
- Doctors see only their own appointments
- Receptionists can create/edit but not delete
- Use granular permissions for confirm/complete/cancel actions
- Run seeder after deployment: `php artisan db:seed --class=RolesAndPermissionsSeeder`


