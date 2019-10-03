<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Journey;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function store(Request $request, Journey $journey)
    {
        $data = $request->validate([
            'body' => 'required|string|min:3|max:200'
        ]);

        $data['journey_id'] = $journey->id;

        $comment = auth()->user()->comments()->create($data);

        if ($comment) {
            return redirect()->route('journeys.show', compact('journey'))
                ->with('flash', [
                    'status' => 'success',
                    'message' => 'Commentaire ajouté'
                ]);
        } else {
            return redirect()->route('journeys.show', compact('journey'))
                ->with('flash', [
                    'status' => 'error',
                    'message' => 'Une erreur est survenue lors de la création du commentaire'
                ]);
        }

    }

    public function edit(Journey $journey, Comment $comment)
    {
        $this->authorize('update', $comment);

        return view('comments.edit', compact(['journey', 'comment']));
    }

    public function update(Request $request, Journey $journey, Comment $comment)
    {
        $this->authorize('update', $comment);

        $data = $request->validate([
            'body' => 'required|min:3|max:200'
        ]);

        if ($comment->update($data)) {
            return redirect()->route('journeys.show', compact('journey'))
                ->with('flash', [
                    'status' => 'success',
                    'message' => 'Commentaire modifié'
                ]);
        }

        return redirect()->route('journeys.show', compact('journey'))
            ->with('flash', [
                'status' => 'error',
                'message' => 'Une erreur est survenue lors de la modification du commentaire'
            ]);
    }

    public function destroy(Journey $journey, Comment $comment)
    {
        $this->authorize('destroy', $comment);

        if ($comment->delete()) {
            return redirect()->route('journeys.show', compact('journey'))
                ->with('flash', [
                    'status' => 'success',
                    'message' => 'Commentaire supprimé'
                ]);
        }

        return redirect()->route('journeys.show', compact('journey'))
            ->with('flash', [
                'status' => 'error',
                'message' => 'Une erreur est survenue lors de la suppression du commentaire'
            ]);

    }
}
