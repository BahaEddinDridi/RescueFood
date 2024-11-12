@extends('admin.layouts.app')

@section('content')
<div class="container">
    <!-- Post Details Section -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <img src="{{ asset('storage/' . $post->user->profile_picture) }}" alt="User Image" class="rounded-circle me-2" width="40" height="40">
            <div>
                <h5 class="mb-0">{{ $post->titre }}</h5>
                <small>Posté par: <strong>{{ $post->user->getFullNameAttribute() }}</strong> | Date: {{ $post->created_at->format('d M Y, H:i') }}</small>
            </div>
            <!-- Delete Button -->
            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="ms-auto" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette publication ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Supprimer</button>
            </form>
        </div>
        <div class="card-body">
            <p><strong>Type de publication:</strong> {{ $post->type_post }}</p>
            <p>{{ $post->contenu }}</p>
            
            <!-- Post Image -->
            @if($post->image_url)
                <div class="text-center mt-3">
                    <img src="{{ asset($post->image_url) }}" alt="Post Image" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                </div>
            @endif
        </div>
        <div class="card-footer d-flex justify-content-between">
            <span>{{ $post->likes->count() }} J'aime(s)</span>
            <span>{{ $post->comments->count() }} Commentaire(s)</span>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Commentaires</h5>
        </div>
        <div class="card-body">
            @forelse($post->comments as $comment)
                <div class="d-flex align-items-start mb-3">
                    <img src="{{ asset('storage/' . $comment->user->profile_picture) }}" alt="Comment User Image" class="rounded-circle me-3" width="40" height="40">
                    <div class="flex-grow-1">
                        <p class="mb-1"><strong>{{ $comment->user->getFullNameAttribute() }}</strong> - <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small></p>
                        <p>{{ $comment->contenu }}</p>
                    </div>
                </div>
                @if(!$loop->last)
                    <hr>
                @endif
            @empty
                <p class="text-muted">Aucun commentaire disponible pour cette publication.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
