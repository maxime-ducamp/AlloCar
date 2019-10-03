<?php

namespace Tests\Unit;

use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RolesTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createRoles();

        $this->user = factory('App\User')->create();
    }

    /** @test */
    public function users_can_be_moderators ()
    {
        $this->assertFalse($this->user->hasRole('moderator'));

        $this->user->addRole('moderator');

        $this->assertTrue($this->user->hasRole('moderator'));
    }

    /** @test */
    public function users_can_be_admin ()
    {
        $this->assertFalse($this->user->hasRole('admin'));

        $this->user->addRole('admin');

        $this->assertTrue($this->user->hasRole('admin'));
    }

    /** @test */
    public function users_can_be_super_admin ()
    {
        $this->assertFalse($this->user->hasRole('super_admin'));

        $this->user->addRole('super_admin');

        $this->assertTrue($this->user->hasRole('super_admin'));
    }
}
