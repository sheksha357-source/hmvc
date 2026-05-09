<?php

namespace Modules\Post\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Post\Models\Post;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::latest()->get();

        return view('post::index', compact('posts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'max:1000'],
        ]);

        $user = Auth::user();

        Post::create([
            'user_id' => $user->id,
            'author_name' => $user->name,
            'body' => $data['body'],
        ]);

        return redirect()->route('dashboard')->with('status', 'Post published.');
    }
}
