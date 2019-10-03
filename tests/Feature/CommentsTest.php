<?php

namespace Tests\Feature;

use App\Comment;
use App\Journey;
use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->createRoles();
    }

    /** @test */
    public function registered_users_can_comment_comments_on_journeys()
    {
        $journey = $this->createJourney();

        $user = factory(User::class)->create();

        $comment = factory(Comment::class)->raw([
            'user_id' => $user->id,
            'journey_id' => $journey->id,
            'body' => 'comment body',
        ]);

        $this->actingAs($user)->post('/trajets/' . $journey->id . '/commentaires', $comment);

        $this->assertDatabaseHas('comments', $comment);
        $this->assertEquals(1, $user->comments->count());
    }

    /** @test */
    public function guests_cannot_create_comments()
    {
        $this->createJourney();

        $data = factory('App\Comment')->raw();

        $this->post('/trajets/1/commentaires', $data)
            ->assertStatus(302)
            ->assertRedirect('/connection');
    }

    /** @test */
    public function authorized_users_can_update_comments ()
    {
        $comment = $this->createComment();

        $data = ['body' => 'updated comment'];

        $this->actingAs($comment->user)->put('/trajets/1/commentaires/1',$data);

        $this->assertDatabaseHas('comments', ['body' => 'updated comment']);
        $this->assertEquals('updated comment', Comment::first()->body);
    }

    /** @test */
    public function authorized_users_can_see_the_edit_comment_page ()
    {
        $comment = $this->createComment();

        $this->actingAs($comment->user)->get('/trajets/1/commentaires/1/modifier')
            ->assertStatus(200)
            ->assertSee('Modifier votre commentaire');
    }

    /** @test */
    public function guests_and_unauthorized_cannot_see_the_edit_comment_page ()
    {
        $this->createComment();

        $this->get('/trajets/1/commentaires/1/modifier')
            ->assertStatus(302)
            ->assertRedirect('/connection');

        $this->login();

        $this->get('/trajets/1/commentaires/1/modifier')
            ->assertStatus(403);
    }

    /** @test */
    public function guests_cannot_update_comments ()
    {
        $this->createComment();

        $data = [
            'body' => 'updated comment'
        ];

        $this->put('/trajets/1/commentaires/1', $data)
            ->assertStatus(302)
            ->assertRedirect('/connection');
    }

    /** @test */
    public function users_can_delete_their_comments ()
    {
        $comment = $this->createComment();

        $this->actingAs($comment->user)->delete('/trajets/1/commentaires/1/supprimer')
            ->assertRedirect('/trajets/1');
    }

    /** @test */
    public function guests_and_unauthorized_users_cannot_delete_other_users_comments ()
    {
        $this->createComment();

        $this->delete('/trajets/1/commentaires/1/supprimer')
            ->assertStatus(302)
            ->assertRedirect('/connection');

        $this->login();

        $this->delete('/trajets/1/commentaires/1/supprimer')
            ->assertStatus(403);
    }

}

