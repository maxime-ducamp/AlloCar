<?php

namespace Tests\Feature;

use App\Comment;
use App\Journey;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModerationTest extends TestCase
{
    use RefreshDatabase;

    protected $moderator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createRoles();

        $this->moderator = factory('App\User')->create()->addRole('moderator');
    }

    /** @test */
    public function moderators_can_see_the_comments_edit_button()
    {
        $comment = $this->createComment();
        $this->actingAs($this->moderator)->get('/trajets/1')
            ->assertSee('Modifier');
    }

    /** @test */
    public function moderators_can_see_the_comments_delete_button()
    {
        $comment = $this->createComment();
        $this->actingAs($this->moderator)->get('/trajets/1')
            ->assertSee('Supprimer');
    }

    /** @test */
    public function moderators_can_update_comments()
    {
        $comment = $this->createComment();
        $this->actingAs($this->moderator)->put('/trajets/1/commentaires/1', ['body' => 'moderated']);

        $this->assertDatabaseHas('comments', ['body' => 'moderated']);
    }

    /** @test */
    public function moderators_can_delete_comments()
    {
        $comment = $this->createComment();
        $this->actingAs($this->moderator)->delete('/trajets/1/commentaires/1/supprimer');

        $this->assertEquals(0, Comment::count());
    }

    /** @test */
    public function moderators_cannot_access_the_admin_backend()
    {
        $this->actingAs($this->moderator)->get('/admin/accueil')
            ->assertStatus(302)
            ->assertRedirect('/');
    }

    /** @test */
    public function moderators_cannot_delete_journeys()
    {
        factory(Journey::class)->create();

        /** A record is present in the journeys table */
        $this->assertEquals(1, Journey::count());

        $this->actingAs($this->moderator)->delete('/trajets/1')
            ->assertStatus(403);

        /** Should still be 1 record */
        $this->assertEquals(1, Journey::count());
    }
}
