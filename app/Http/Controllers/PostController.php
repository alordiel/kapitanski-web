<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        return view('post.index', [
            'posts' => Post::all()
        ]);
    }

    public function manage(): View
    {
        return view('post.manage', [
            'posts' => Post::all()
        ]);
    }

    public function create(): View
    {
        return view('post.create');
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'slug' => ['required'],
            'content' => 'required',
            'featured_image' => 'required',
            'excerpt' => 'required',
        ]);

        Post::create($formFields);

        return redirect('/admin/posts')->with('message', 'Post successfully created');
    }

    public function show(Post $post): View
    {
        return view('post.show', ['post' => $post]);
    }

    public function edit(Post $post): View
    {
        return view('post.edit', ['post' => $post]);
    }

    public function update(Request $request, Post $post)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'slug' => ['required'],
            'content' => 'required',
            'featured_image' => 'required',
            'excerpt' => 'required',
        ]);

        $post->update($formFields);

        return back()->with('message', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('/admin/posts')->with('message', 'Deleted successfully');
    }
}
