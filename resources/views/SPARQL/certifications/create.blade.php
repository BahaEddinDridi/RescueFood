@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter une Certification</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('certificats.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="label" class="form-label">Label</label>
            <input type="text" class="form-control" id="label" name="label" required>
            @error('label')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="uri" class="form-label">URI</label>
            <input type="url" class="form-control" id="uri" name="uri" required>
            @error('uri')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Ajouter Certification</button>
    </form>
</div>
@endsection
