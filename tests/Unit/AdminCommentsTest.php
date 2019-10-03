<?php

namespace Tests\Feature;

use App\Comment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminCommentsTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $comment;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createRoles();

        $this->admin = $this->createAdmin();
        $this->comment = $this->createComment();
    }

    /** @test */
    public function admin_users_can_delete_comments ()
    {
        $this->actingAs($this->admin)->delete('/admin/commentaires/1');

        $this->assertEquals(0, Comment::count());
    }


    /** @test */
    public function admin_users_can_update_comments ()
    {
        $this->actingAs($this->admin)->put('/admin/commentaires/1', [
            'body' => 'admin_updated',
        ]);

        $this->assertEquals(Comment::first()->body, 'admin_updated');
    }
}
