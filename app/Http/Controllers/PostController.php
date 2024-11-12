<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import for authenticated user

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('user')->orderBy('created_at', 'desc')->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required',
            'contenu' => 'required',
            'type_post' => 'required',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $imageName = time() . '.' . $image->getClientOriginalExtension();


            $imagePath = $image->storeAs('public/images', $imageName);


            $imagePath = str_replace('public/', 'storage/', $imagePath);
        }


        Auth::user()->posts()->create([
            'titre' => $request->input('titre'),
            'contenu' => $request->input('contenu'),
            'type_post' => $request->input('type_post'),
            'image_url' => $imagePath,
        ]);

        return redirect()->route('home')->with('success', 'Publication créée avec succès.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Fetch post with its associated user
        $post = Post::with('user', 'comments.user')->find($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'titre' => 'required',
            'contenu' => 'required',
            'type_post' => 'required',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        $post = Post::find($id);

        // Handle image update if a new image is uploaded
        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/images', $imageName);
            $imagePath = str_replace('public/', 'storage/', $imagePath);
            $post->image_url = $imagePath;
        }

        $post->update([
            'titre' => $request->input('titre'),
            'contenu' => $request->input('contenu'),
            'type_post' => $request->input('type_post'),
            // No need to update user_id, as the user remains the same
        ]);

        return redirect()->route('home')->with('success', 'Publication mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::find($id)->delete();

        return redirect()->route('home')->with('success', 'Publication supprimée avec succès.');
    }

    public function toggleLike($id)
    {
        $post = Post::findOrFail($id);
        $user = auth()->user();

       
        $like = $post->likes()->where('user_id', $user->id)->first();

        if ($like) {
          
            $like->delete();
        } else {
            $post->likes()->create([
                'user_id' => $user->id,
            ]);

           
            $postOwner = $post->user;
            if ($postOwner->id !== $user->id) {
                $postOwner->notifications()->create([
                    'titre' => 'Nouveau like',
                    'message' => "{$user->getFullNameAttribute()} a aimé votre publication.",
                    'type' => 'like',
                    'est_vu' => false,
                ]);
            }
        }

        return back();
    }

    public function storeComment(Request $request, $postId)
    {
        $request->validate([
            'contenu' => 'required|string|max:1000',
        ]);

        $post = Post::findOrFail($postId);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'contenu' => $request->input('contenu'),
        ]);

        $postOwner = $post->user;
        if ($postOwner->id !== auth()->id()) {
            $postOwner->notifications()->create([
                'titre' => 'Nouveau commentaire',
                'message' => auth()->user()->getFullNameAttribute() . ' a commenté votre publication.',
                'type' => 'comment',
                'est_vu' => false,
            ]);
        }
        return back()->with('success', 'Comment added successfully.');
    }

}
