<?php

namespace Tests\Feature;

use App\ConversationMessage;
use App\PrivateMessage;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PrivateMessagesTest extends TestCase
{
    use RefreshDatabase;

    protected $sender;
    protected $receiver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createRoles();

        $this->sender = factory('App\User')->create();
        $this->receiver = factory('App\User')->create();
    }

    /** @test */
    public function users_can_send_private_messages_to_other_users()
    {
        $this->sender->sendMessageTo($this->receiver, 'test_subject', 'test_body');

        $this->assertDatabaseHas('private_messages', [
            'from_id' => $this->sender->id,
            'to_id' => $this->receiver->id,
            'subject' => 'test_subject',
            'body' => 'test_body'
        ]);

        $this->assertEquals(1, PrivateMessage::all()->count());
        $this->assertEquals(1, $this->sender->sent()->count());
        $this->assertEquals(1, $this->receiver->received()->count());
    }

    /** @test */
    public function users_can_see_their_messages_in_their_inbox()
    {
        $this->sender->sendMessageTo($this->receiver, 'test_subject', 'test_body');

        $this->actingAs($this->receiver)->get('utilisateurs/' . $this->receiver->name . '/messages')
            ->assertSee('Messages reçus')
            ->assertSee(PrivateMessage::first()->subject);
    }

    /** @test */
    public function only_authenticated_users_can_access_their_inboxes()
    {
        $user = factory(User::class)->create();
        $unauthorized = factory(User::class)->create();

        $this->actingAs($unauthorized)->get('utilisateurs/' . $user->name . '/messages')
            ->assertStatus(403);
    }

    /** @test */
    public function private_messages_can_be_marked_as_read()
    {
        $this->sender->sendMessageTo($this->receiver, 'test_subject', 'test_body');

        $this->actingAs($this->receiver)->post('utilisateurs/' . $this->receiver->name . '/messages/1/marquer-comme-lu');

        $this->assertNotNull(PrivateMessage::first()->read_at);
    }

    /** @test */
    public function users_can_answer_to_pms()
    {
        $this->sender->sendMessageTo($this->receiver, 'test_subject', 'test_body');

        $this->actingAs($this->receiver)->post('utilisateurs/' . $this->receiver->name .'/messages/1/repondre', [
            'subject' => 'test_answer_subject',
            'body' => 'test_answer',
        ]);

        $this->assertEquals(2, PrivateMessage::all()->count());
        $this->assertEquals(PrivateMessage::find(2)->to_id, $this->sender->id);
        $this->assertInstanceOf(PrivateMessage::class, $this->sender->received()->first());
    }

    /** @test */
    public function trying_to_send_a_private_message_returns_a_boolean ()
    {
        $target = $this->sender->sendMessageTo($this->receiver, 'test_subject', 'test_body');

        $this->assertIsBool($target);
    }
}
