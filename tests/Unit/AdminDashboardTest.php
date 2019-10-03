<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use App\Comment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected $super_admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createRoles();

        $this->admin = $this->createAdmin();
        $this->super_admin = factory('App\User')->create()->addRole('super_admin');
    }

    /** @test */
    public function admin_users_can_access_the_admin_dashboard()
    {
        $this->actingAs($this->admin)->get('/admin/accueil')
            ->assertStatus(200);
    }

    /** @test */
    public function unauthorized_users_cannot_access_the_admin_dashboard()
    {
        $this->get('/admin/accueil')
            ->assertStatus(302)
            ->assertRedirect('/');
    }

    /** @test */
    public function admin_users_can_access_a_list_of_users()
    {
        $user = factory(User::class)->create();

        /** Here we are asserting the first user (admin) sees the name of a second one */
        $this->actingAs($this->admin)->get('/admin/utilisateurs')
            ->assertSee($user->name);
    }

    /** @test */
    public function admin_users_can_access_a_list_of_comments ()
    {
        factory(Comment::class, 10)->create();

        $this->actingAs($this->admin)->get('/admin/commentaires')
            ->assertSee(Comment::first()->body);
    }

    /** @test */
    public function super_admins_can_access_the_admin_dashboard ()
    {
        $this->actingAs($this->super_admin)->get('/admin/accueil')
            ->assertStatus(200);
    }

    /** @test */
    public function moderators_cannot_access_the_admin_dashboard ()
    {
        $moderator = factory('App\User')->create()->addRole('moderator');

        $this->actingAs($moderator)->get('/admin/accueil')
            ->assertStatus(302)
            ->assertRedirect('/');
    }
}
