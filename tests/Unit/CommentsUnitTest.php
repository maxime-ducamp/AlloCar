<?php

namespace Tests\Unit;

use App\User;
use App\Comment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentsUnitTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createroles();
    }

    /** @test */
    public function comments_can_be_created ()
    {
        $journey = $this->createJourney();
        $this->login(factory(User::class)->create())
            ->post('/trajets/' . $journey->id . '/commentaires', [
            'body' => 'new_comment'
        ]);

        $this->assertEquals(1, Comment::count());
    }

    /** @test */
    public function comments_can_be_deleted ()
    {
        $comment = $this->createComment();

        $this->actingAs($comment->user)
            ->delete('/trajets/1/commentaires/' . $comment->id .'/supprimer');

        $this->assertEquals(0, Comment::count());
    }

    /** @test */
    public function comments_can_be_updated ()
    {
        $comment = $this->createComment();

        $this->actingAs($comment->user)
            ->put('/trajets/1/commentaires/1', [
                'body' => 'updated_comment'
            ]);

        $this->assertEquals('updated_comment', $comment->fresh()->body);
    }
}
