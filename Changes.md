# Changelog: Implementation of Spatie Laravel-Permission

## Overview

Successfully integrated [`spatie/laravel-permission`](https://spatie.be/docs/laravel-permission) v6.24 to provide dynamic role and permission management. This update encompasses backend logic changes, database structure updates, and a comprehensive CRUD UI for administrators.

## Detailed Changes

### 📦 Package & Configuration

- **Installed:** `spatie/laravel-permission` v6.24.
- **[composer.json](composer.json)**: Added package dependency.
- **Published:**
    - Configuration: [`config/permission.php`](config/permission.php)
    - Migration: [`database/migrations/2026_02_10_084034_create_permission_tables.php`](database/migrations/2026_02_10_084034_create_permission_tables.php)
- **Migration Update:** Modified the default migration to use `uuid` for `model_morph_key` columns (`model_has_roles`, `model_has_permissions`) to ensure compatibility with the UUID-based `User` model.

### 🏗 Models

- **[`app/Models/User.php`](app/Models/User.php)**
    - Implemented `Spatie\Permission\Traits\HasRoles` trait.
    - Enables usage of methods like `$user->assignRole()`, `$user->getAllPermissions()`, and `$user->hasRole()`.

### 🛡 Middleware

- **[`bootstrap/app.php`](bootstrap/app.php)**
    - Registered Spatie's built-in middleware aliases:
        - `role`
        - `permission`
        - `role_or_permission`
    - Removed reference to the custom `App\Http\Middleware\RoleCheck` class.

### 🎮 Controllers

- **[`app/Http/Controllers/RoleController.php`](app/Http/Controllers/RoleController.php)** (New)
    - Implements full CRUD functionality for Roles.
    - Integrates DataTables for server-side rendering.
    - Handles permission syncing logic (`$role->syncPermissions()`).
    - Includes safeguards to prevent modification or deletion of the `superadmin` role.
- **[`app/Http/Controllers/PermissionController.php`](app/Http/Controllers/PermissionController.php)** (New)
    - Implements CRUD functionality for Permissions.
    - Integrates DataTables for listing.
- **[`app/Http/Controllers/UserController.php`](app/Http/Controllers/UserController.php)**
    - Updated `index()` to display roles fetched from the relationship/database instead of the static enum.
    - Updated `store()` and `update()` methods to execute `$user->syncRoles()` alongside the existing logic, ensuring Spatie roles are assigned.

### ✅ Request Validation

- **[`app/Http/Requests/Role/StoreRoleRequest.php`](app/Http/Requests/Role/StoreRoleRequest.php)** & **[`UpdateRoleRequest.php`](app/Http/Requests/Role/UpdateRoleRequest.php)**
    - Validates uniqueness of role names.
    - Validates that selected permissions exist in the database.
- **[`app/Http/Requests/Permission/StorePermissionRequest.php`](app/Http/Requests/Permission/StorePermissionRequest.php)** & **[`UpdatePermissionRequest.php`](app/Http/Requests/Permission/UpdatePermissionRequest.php)**
    - Validates uniqueness of permission names.
- **[`app/Http/Requests/User/StoreUserRequest.php`](app/Http/Requests/User/StoreUserRequest.php)** & **[`UpdateUserRequest.php`](app/Http/Requests/User/UpdateUserRequest.php)**
    - Updated the `role` field validation. It now checks for existence in the `roles` table (`exists:roles,name`) rather than validating against the `UserRole` enum.

### 👁 Views (Blade)

- **[`resources/views/pages/dashboard/roles/index.blade.php`](resources/views/pages/dashboard/roles/index.blade.php)** (New)
    - UI for Managing Roles.
    - Features a DataTables list and an HSOverlay modal form with checkbox inputs for assigning permissions.
- **[`resources/views/pages/dashboard/permissions/index.blade.php`](resources/views/pages/dashboard/permissions/index.blade.php)** (New)
    - UI for Managing Permissions.
    - Features a simplified DataTables list and Modal form.
- **[`resources/views/pages/dashboard/users/index.blade.php`](resources/views/pages/dashboard/users/index.blade.php)**
    - Updated the "Role" dropdown in the Create/Edit User modal to populate dynamically from the `roles` table.
- **[`resources/views/components/dashboard/sidebar-nav.blade.php`](resources/views/components/dashboard/sidebar-nav.blade.php)**
    - Added "Roles" and "Permissions" navigation items under the "Manage" section.
    - Updated visibility logic to check via `$user->hasRole('superadmin')`.

### 🛣 Routes

- **[`routes/web.php`](routes/web.php)**
    - Registered resource routes for `roles` and `permissions`.
    - Protected these routes under the `auth`, `verified`, and `role:superadmin` middleware group.

### 🌱 Seeders

- **[`database/seeders/RolesAndPermissionsSeeder.php`](database/seeders/RolesAndPermissionsSeeder.php)** (New)
    - Initializes default permissions: `view-dashboard`, `manage-users`, `manage-roles`, `manage-permissions`.
    - Initializes default roles (`superadmin`, `admin`, `user`) and assigns the appropriate permissions.
- **[`database/seeders/DatabaseSeeder.php`](database/seeders/DatabaseSeeder.php)**
    - Added call to `RolesAndPermissionsSeeder`.
- **[`database/seeders/Users.php`](database/seeders/Users.php)**
    - Updated the user generation loop to automatically assign the Spatie role (`$user->assignRole()`) that corresponds to the user's data.

## Default Data (Roles & Permissions)

| Role             | Permissions                                                            |
| :--------------- | :--------------------------------------------------------------------- |
| **`superadmin`** | `view-dashboard`, `manage-users`, `manage-roles`, `manage-permissions` |
| **`admin`**      | `view-dashboard`, `manage-users`                                       |
| **`user`**       | `view-dashboard`                                                       |
