<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SetupTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createRoles();
    }


    /** @test */
    public function login_method_logs_a_user_in ()
    {
        $this->assertNull(auth()->user());

        $this->login();

        $this->assertInstanceOf(User::class, auth()->user());

        auth()->logout();

        $user = factory(User::class)->create();

        $this->login($user);

        $this->assertInstanceOf(User::class, auth()->user());
        $this->assertEquals(auth()->user()->name, $user->name);
    }

    /** @test */
    public function logout_method_logs_out_any_authenticated_users ()
    {
        $user = factory(User::class)->create();

        $this->login($user);

        $this->logout();

        $this->assertFalse(auth()->check());
    }

    /** @test */
    public function the_create_admin_method_returns_a_user_with_role_admin ()
    {
        $prospect = $this->createAdmin();

        $this->assertInstanceOf(User::class, $prospect);
        $this->assertTrue($prospect->hasRole('admin'));
    }
}
