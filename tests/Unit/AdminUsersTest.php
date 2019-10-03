<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminUsersTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createRoles();
        $this->admin = $this->createAdmin();
    }

    /** @test */
    public function admin_users_can_update_other_users_open_infos ()
    {
        $user = factory('App\User')->create();

        $this->actingAs($this->admin)->put('/admin/utilisateurs/' . $user->name, [
            'name' => 'admin_modified_name',
            'email' => $user->email,
            'avatar_path' => $user->avatar_path
        ]);

        $this->assertDatabaseHas('users', ['name' => 'admin_modified_name']);
    }

    /** @test */
    public function admin_users_can_delete_other_users ()
    {
        factory('App\User')->create();

        $this->actingAs($this->admin)->delete('/admin/utilisateurs/' . User::find(2)->name);

        $this->assertEquals(1, User::count());
    }

    /** @test */
    public function admin_users_cannot_see_other_admins_or_super_admins_users_in_the_admin_users_page ()
    {
        $this->withoutExceptionHandling();
        $other_admin = factory('App\User')->create()->addRole('admin');

        $this->actingAs($this->admin)->get('/admin/utilisateurs')
            ->assertDontSee($other_admin->name);
    }
}
