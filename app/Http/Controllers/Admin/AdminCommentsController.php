<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminCommentsController extends Controller
{
    public function index()
    {
        $comments = Comment::paginate(50);

        return view('admin.comments.index', compact('comments'));
    }

    public function edit(Comment $comment)
    {
        return view('admin.comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $data = $request->validate([
            'body' => 'required|string|min:3|max:200'
        ]);

        if ($comment->update($data)) {
            return redirect()->route('admin.comments.index')
                ->with('flash', [
                    'status' => 'success',
                    'message' => 'Commentaire modifié'
                ]);
        } else {
            return redirect()->back()->with('flash', [
                'status' => 'error',
                'message' => 'Une erreur est survenue'
            ]);
        }
    }

    public function destroy(Comment $comment)
    {
        if ($comment->delete()) {
            return redirect()->route('admin.comments.index')
                ->with('flash', [
                    'status' => 'success',
                    'message' => 'Commentaire supprimé'
                ]);
        } else {
            return redirect()->back()->with('flash', [
                'status' => 'error',
                'message' => 'Une erreur est survenue'
            ]);
        }
    }

}
