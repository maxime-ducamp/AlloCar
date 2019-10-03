<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendPrivateMessageRequest;
use App\PrivateMessage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PrivateMessagesController extends Controller
{
    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(User $user)
    {
        $this->authorize('manage', $user);

        $received = auth()->user()->received()->where('read_at', null)->get();
        $sent = auth()->user()->sent;

        return view('profiles.messages.index', compact([
            'received', 'sent'
        ]));
    }

    /**
     * @param SendPrivateMessageRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMessage(SendPrivateMessageRequest $request, User $user)
    {
        $data = $request->validated();

        if (auth()->user()->sendMessageTo($user, $data['subject'], $data['body'])) {
           return redirect()->back()->with('flash', [
               'status' => 'success',
               'message' => 'Message envoyé à ' . $user->name
           ]);
        } else {
            return redirect()->back()->with('flash', [
                'status' => 'error',
                'message' => 'Une erreur est survenue lors de l\'envoi de votre message'
            ]);
        }

    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function markAsRead(Request $request, User $user)
    {
        $this->authorize('manage', $user);

        if ($request->private_message) {

            $message = $user->received()->find($request->private_message);

            if ($message) {
                $message->update([
                    'read_at' => Carbon::now()
                ]);
                return back();
            }
        } else {
            return redirect()->route('profiles.index', compact('user'));
        }
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function answer(Request $request, User $user)
    {
        $this->authorize('manage', $user);

        if ($request->private_message) {

            $message = $user->received()->find($request->private_message);

            if ($message) {
                return view('profiles.messages.answer', compact('message'));
            }

        } else {
            return redirect()->route('profiles.index', compact('user'));
        }
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function storeAnswer(Request $request, User $user)
    {
        $this->authorize('manage', $user);

        $data = $request->validate([
            'subject' => 'required|string|min:5',
            'body' => 'required|string|min:5',
        ]);

        if ($request->private_message) {
            $original_message = $user->received()->find($request->private_message);

            if ($original_message) {
                auth()->user()->sendMessageTo($original_message->sender, $data['subject'], $data['body']);
            }
        }
        return redirect()->route('profiles.index', compact('user'));
    }
}
