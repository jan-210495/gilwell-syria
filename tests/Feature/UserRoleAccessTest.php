<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Filament\Panel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admins_and_editors_can_access_filament(): void
    {
        $panel = Panel::make()->id('admin');

        $admin = User::factory()->create(['role' => UserRole::Admin]);
        $editor = User::factory()->create(['role' => UserRole::Editor]);
        $unassigned = User::factory()->create(['role' => null]);

        $this->assertTrue($admin->canAccessPanel($panel));
        $this->assertTrue($editor->canAccessPanel($panel));
        $this->assertFalse($unassigned->canAccessPanel($panel));
    }

    public function test_role_helpers_identify_admins_and_editors(): void
    {
        $admin = User::factory()->make(['role' => UserRole::Admin]);
        $editor = User::factory()->make(['role' => UserRole::Editor]);
        $unassigned = User::factory()->make(['role' => null]);

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isEditor());

        $this->assertFalse($editor->isAdmin());
        $this->assertTrue($editor->isEditor());

        $this->assertFalse($unassigned->isAdmin());
        $this->assertFalse($unassigned->isEditor());
    }
}
