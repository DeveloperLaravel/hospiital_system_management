# Appointments CRUD with Livewire - Plan

## Task: Create complete Appointments CRUD using Livewire with roles/permissions integration

## Steps to Complete:

### 1. Update Appointment Model
- [ ] Fix relationships in Appointment model to use Patient and Doctor models
- [ ] Add proper relationships

### 2. Update Patient and Doctor Models  
- [ ] Add appointments relationship to Patient model
- [ ] Add appointments relationship to Doctor model

### 3. Create Livewire Component
- [ ] Create Livewire component: app/Http/Livewire/Appointments.php
- [ ] Implement CRUD operations (create, read, update, delete)
- [ ] Add search and filter functionality
- [ ] Add permission checks using Spatie

### 4. Create Livewire View
- [ ] Create view: resources/views/livewire/appointments.blade.php
- [ ] Professional Arabic UI with RTL support
- [ ] Modal forms for create/edit
- [ ] Status badges with colors
- [ ] Confirmation dialogs for delete

### 5. Update Routes
- [ ] Uncomment and update the appointments route in routes/web.php
- [ ] Add proper middleware for permissions

### 6. Create Permissions Seeder
- [ ] Add appointment permissions to seeder
- [ ] Run seeder to create permissions

## Dependencies:
- Livewire is already installed
- Spatie Permission is already installed
- Tailwind CSS is already configured
- Arabic fonts and RTL support already exists

## Files to Create/Modify:
1. app/Models/Appointment.php - Update relationships
2. app/Models/Patient.php - Add appointments relationship  
3. app/Models/Doctor.php - Add appointments relationship
4. app/Http/Livewire/Appointments.php - Create (NEW)
5. resources/views/livewire/appointments.blade.php - Create (NEW)
6. routes/web.php - Update route
7. database/seeders/RolesAndPermissionsSeeder.php - Add permissions

## Permissions to Create:
- appointment-list
- appointment-create
- appointment-edit
- appointment-delete
- appointment-view

## Follow-up:
- Test the CRUD operations
- Verify permissions work correctly
- Check Arabic UI displays correctly
