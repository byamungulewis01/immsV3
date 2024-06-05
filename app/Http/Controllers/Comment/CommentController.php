<?php

namespace App\Http\Controllers\Comment;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function index()
    {

        $comments = Comment::orderBy('id', 'desc')->get();
        return view('admin.comment.index', compact('comments'));
    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'name' => 'required',
        ]);

        $inbox = Comment::create($formField);
        return back()->with('success', 'Comment Registration Successfully');
    }
    public function update(Request $request, $id)
    {
        $formField = $request->validate([
            'name' => 'required',
        ]);
        Comment::findOrFail($id)->update($formField);
        return back()->with('success', 'Comment Updated Successfully');
    }
}
