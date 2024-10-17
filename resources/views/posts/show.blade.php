@extends('layouts.app')

@section('content')
<div class="container-fluid p-4" style="margin-top: 80px">
    <div class="row justify-content-center">
        <!-- Main Post Section -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <!-- Post Header -->
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <!-- User Info (Profile Picture, Name, Timestamp) -->
                    <div class="d-flex align-items-center">
                        <img src="{{ asset($post->user->profile_picture ?? 'path/to/default-profile.jpg') }}" alt="User Profile" class="rounded-circle" width="50" height="50" style="object-fit: cover; margin-right: 10px;">
                        <div>
                            <h6 class="mb-0 font-weight-bold">{{ $post->user->getFullNameAttribute() }}</h6>
                            <small class="text-muted">{{ $post->created_at->format('d M Y, H:i') }}</small>
                        </div>
                    </div>

                    <!-- Edit/Delete Icons (Visible Only for Post Owner) -->
                    @if(Auth::check() && Auth::id() === $post->user_id)
                        <div class="d-flex">
                            <!-- Edit Button -->
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-link text-info btn-sm p-0 mx-2" data-bs-toggle="tooltip" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <!-- Delete Button -->
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger btn-sm p-0 mx-2" data-bs-toggle="tooltip" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette publication ?');">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Post Image (if exists) -->
                @if($post->image_url)
                    <img src="{{ asset($post->image_url) }}" alt="Image" class="card-img-top" style="max-height: 400px; object-fit: cover;">
                @endif

                <!-- Post Body -->
                <div class="card-body">
                    <h3 class="font-weight-bold">{{ $post->titre }}</h3>
                    <p class="card-text">{{ $post->contenu }}</p>
                </div>

                <!-- Post Footer (like, comment, share) -->
                <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                    <!-- Like Button -->
                    <form action="{{ route('posts.like', $post->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @if($post->isLikedByUser())
                            <button type="submit" class="btn btn-link text-danger p-0">
                                <i class="fas fa-heart"></i> {{ $post->likes->count() }} <!-- Filled heart if liked -->
                            </button>
                        @else
                            <button type="submit" class="btn btn-link text-muted p-0">
                                <i class="far fa-heart"></i> {{ $post->likes->count() }} <!-- Empty heart if not liked -->
                            </button>
                        @endif
                    </form>

                    <!-- Comment Button -->
                    <button class="btn btn-link text-muted p-0">
                        <i class="far fa-comment"></i> Commenter
                    </button>

                    <!-- Share Button -->
                    <button class="btn btn-link text-muted p-0">
                        <i class="fas fa-share"></i> Partager
                    </button>
                </div>
            </div>

            <!-- Comment Section (Optional) -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="font-weight-bold">Commentaires</h5>
                    
                    <!-- Fake Comments -->
                    <div class="d-flex mb-3">
                        <img src="{{ asset('path/to/default-profile.jpg') }}" alt="User Profile" class="rounded-circle" width="40" height="40" style="object-fit: cover; margin-right: 10px;">
                        <div>
                            <h6 class="mb-0">John Doe</h6>
                            <small class="text-muted">Il y a 2 heures</small>
                            <p class="mb-0">Super post, j'aime beaucoup !</p>
                        </div>
                    </div>
            
                    <div class="d-flex mb-3">
                        <img src="{{ asset('path/to/default-profile.jpg') }}" alt="User Profile" class="rounded-circle" width="40" height="40" style="object-fit: cover; margin-right: 10px;">
                        <div>
                            <h6 class="mb-0">Jane Smith</h6>
                            <small class="text-muted">Il y a 5 heures</small>
                            <p class="mb-0">Très intéressant, merci pour le partage !</p>
                        </div>
                    </div>
            
                    <div class="d-flex mb-3">
                        <img src="{{ asset('path/to/default-profile.jpg') }}" alt="User Profile" class="rounded-circle" width="40" height="40" style="object-fit: cover; margin-right: 10px;">
                        <div>
                            <h6 class="mb-0">Emily Brown</h6>
                            <small class="text-muted">Il y a 1 jour</small>
                            <p class="mb-0">C'est exactement ce dont j'avais besoin, merci beaucoup !</p>
                        </div>
                    </div>
            
                    <!-- Add a Comment (if logged in) -->
                    @if(Auth::check())
                        <form action="#" method="POST">
                            @csrf
                            <div class="form-group">
                                <textarea name="contenu" class="form-control" rows="3" placeholder="Ajouter un commentaire..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Commenter</button>
                        </form>
                    @else
                        <p class="text-muted">Vous devez être connecté pour commenter.</p>
                    @endif
                </div>
            </div>
            
        </div>

        <!-- Sidebar (User Info) -->
        <div class="col-lg-4">
            <div class="sticky-top" style="top: 80px;">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body text-center">
                        <img src="{{ asset(Auth::user()->profile_picture ?? 'path/to/default-profile.jpg') }}" alt="User Profile" class="rounded-circle mb-3" width="100" height="100" style="object-fit: cover;">
                        <h5 class="card-title">{{ Auth::user()->getFullNameAttribute() }}</h5>
                        <p class="text-muted">{{ Auth::user()->email }}</p>
                        <p><strong>Ville:</strong> {{ Auth::user()->city }}</p>
                        <a href="#" class="btn btn-outline-primary btn-sm mt-3">Modifier le profil</a>
                    </div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <a href="{{ route('posts.create') }}" class="btn btn-success btn-block">
                            <i class="fas fa-plus"></i> Créer une nouvelle publication
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
