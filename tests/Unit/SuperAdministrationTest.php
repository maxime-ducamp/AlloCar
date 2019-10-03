<?php

namespace Tests\Feature;

use App\Comment;
use App\Journey;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SuperAdministrationTest extends TestCase
{
    use RefreshDatabase;

    protected $super_admin;

    protected $normal_admin;

    protected $moderator;


    protected function setUp(): void
    {
        parent::setUp();
        $this->createRoles();

        $this->super_admin = factory('App\User')->create()->addRole('super_admin');
        $this->normal_admin = factory('App\User')->create()->addRole('admin');
        $this->moderator = factory('App\User')->create()->addRole('moderator');
    }

    /** @test */
    public function only_super_admins_can_assign_new_roles_to_users()
    {
        $target = factory(User::class)->create();
        $route = '/admin/roles/' . $target->name . '/assigner-un-role';
        $params = ['user_role' => 'admin'];

        /**
         * Moderators cannot, expecting hasRole() to return false
         * and the target's roles count to return 0
         */
        $this->actingAs($this->moderator)->post($route, $params);
        $this->assertFalse($target->hasRole('admin'));
        $this->assertEquals(0, $target->roles()->count());

        /** Likewise, Admins cannot, expecting the same results */
        $this->actingAs($this->normal_admin)->post($route, $params);
        $this->assertFalse($target->hasRole('admin'));
        $this->assertEquals(0, $target->roles()->count());

        /** Super Admins can, hasRole() should return true,
         * target's roles count should be 1
         */
        $this->actingAs($this->super_admin)->post($route, $params);
        $this->assertEquals(1, $target->roles()->count());
        $this->assertTrue($target->hasRole('admin'));
    }

    /** @test */
    public function super_admins_can_remove_a_role_from_a_user()
    {
        $user = factory('App\User')->create()->addRole('admin');

        $this->actingAs($this->super_admin)->post('/admin/roles/' . $user->name . '/retirer-un-role', ['user_role' => 'admin']);

        $this->assertFalse($user->hasRole('admin'));
    }

    /** @test */
    public function super_admins_can_update_users()
    {
        $user = factory('App\User')->create();

        $this->actingAs($this->super_admin)->put('/admin/utilisateurs/' . $user->name, [
            'name' => $user->name,
            'email' => 'modifiedby@admin',
            'avatar_path' => $user->avatar_path
        ]);

        $this->assertDatabaseHas('users', ['email' => 'modifiedby@admin']);
    }

    /** @test */
    public function super_admins_can_delete_users()
    {
        $user = factory('App\User')->create(['name' => 'target']);

        $this->actingAs($this->super_admin)->delete('/admin/utilisateurs/target');

        /** Here we are expecting 3 because we've created 3 users for each role for the set up */
        $this->assertEquals(3, User::count());
    }

    /** @test */
    public function super_admins_can_delete_admins_and_moderators()
    {
        $this->actingAs($this->super_admin)->delete('/admin/utilisateurs/' . $this->moderator->name);
        $this->assertEquals(2, User::count());

        $this->actingAs($this->super_admin)->delete('/admin/utilisateurs/' . $this->normal_admin->name);
        $this->assertEquals(1, User::count());
    }

    /** @test */
    public function super_admins_can_update_comments()
    {
        factory('App\Comment')->create();

        $this->actingAs($this->super_admin)->put('/admin/commentaires/1', ['body' => 'moderated']);
        $this->assertDatabaseHas('comments', ['body' => 'moderated']);
    }

    /** @test */
    public function super_admins_can_delete_comments()
    {
        factory('App\Comment')->create();

        $this->actingAs($this->super_admin)->delete('/admin/commentaires/1');
        $this->assertEquals(0, Comment::count());
    }

    /** @test */
    public function super_admins_can_update_journeys()
    {
        factory('App\Journey')->create();

        $this->actingAs($this->super_admin)->put('/admin/trajets/1', ['departure' => 'updated']);
        $this->assertDatabaseHas('journeys', ['departure' => 'updated']);
    }

    /** @test */
    public function super_admins_can_delete_journeys()
    {
        factory('App\Journey')->create();

        $this->actingAs($this->super_admin)->delete('/admin/trajets/1');
        $this->assertEquals(0, Journey::count());
    }

    /** @test */
    public function super_admins_can_mark_journeys_as_completed()
    {
        factory('App\Journey')->create();

        $this->actingAs($this->super_admin)->post('/trajets/1/complete');

        $this->assertNotNull(Journey::first()->completed_at);
    }
}
