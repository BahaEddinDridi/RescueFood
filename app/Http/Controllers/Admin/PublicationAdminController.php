<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
class PublicationAdminController extends Controller
{
    public function index()
    {
        // Retrieve all posts with associated 'user' and order them by creation date (newest first)
        $posts = Post::with('user')
            ->withCount(['likes', 'comments']) // Add count for likes and comments
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get likes and comments stats for each post
        $likesData = $posts->pluck('likes_count');
        $commentsData = $posts->pluck('comments_count');
        $postTitles = $posts->pluck('titre');

        // Return the view with the posts data and stats
        return view('admin.posts.index', compact('posts', 'likesData', 'commentsData', 'postTitles'));
    }
    public function show($id)
    {
        $post = Post::with(['user', 'likes', 'comments.user'])->findOrFail($id);

        return view('admin.posts.show', compact('post'));
    }
    public function destroy($id)
{
    $post = Post::findOrFail($id);

    $post->delete();

    return redirect()->route('admin.posts.index')->with('success', 'Publication supprimée avec succès!');
}
}
