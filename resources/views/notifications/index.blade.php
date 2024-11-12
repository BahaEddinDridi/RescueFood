@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 mb-5 wow fadeIn" style="margin-top: 100px;">
    <h1>Notifications</h1>

    <div class="row">
        @forelse ($notifications as $notification)
        <div class="col-md-12 mb-3">
            <div class="card shadow-sm border-{{ $notification->est_vu ? 'secondary' : 'primary' }}">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">{{ $notification->titre }}</h5>
                    
                    <!-- Form to mark as seen -->
                    <form action="{{ route('notifications.markAsSeen', $notification->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-link p-0 text-{{ $notification->est_vu ? 'muted' : 'primary' }}">
                            <i class="fas {{ $notification->est_vu ? 'fa-check-circle' : 'fa-bell' }}"></i>
                            {{ $notification->est_vu ? 'Seen' : 'New' }}
                        </button>
                    </form>
                </div>

                <div class="card-body">
                    <p class="card-text">{{ $notification->message }}</p>
                    <p class="text-muted">Type: <strong>{{ ucfirst($notification->type) }}</strong></p>
                </div>
                <div class="card-footer text-muted">
                    <small>{{ $notification->created_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">
                No notifications available.
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
