<?php

namespace Tests\Unit;

use App\Enums\UserRole;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    public function test_values_returns_all_roles(): void
    {
        $this->assertSame([
            'superadmin',
            'admin',
            'user',
        ], UserRole::values());
    }

    public function test_label_returns_translated_string(): void
    {
        $this->assertSame(__('Super Admin'), UserRole::SuperAdmin->label());
        $this->assertSame(__('Admin'), UserRole::Admin->label());
        $this->assertSame(__('User'), UserRole::User->label());
    }
}
