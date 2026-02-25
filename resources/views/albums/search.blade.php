<?php
@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Álbumes</h1>
            @auth
                <a href="{{ route('albums.create') }}" class="btn btn-primary">+ Añadir álbum</a>
            @endauth
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row row-cols-1 row-cols-md-3 g-4">
            @forelse($albums as $album)
                <div class="col">
                    <div class="card h-100">
                        @if($album->cover)
                            <img src="{{ Storage::url($album->cover) }}"
                                 class="card-img-top"
                                 style="height:200px;object-fit:cover"
                                 alt="{{ $album->title }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $album->title }}</h5>
                            <p class="card-text text-muted">{{ $album->artist }} · {{ $album->release_year }}</p>
                            <span class="badge bg-secondary">{{ $album->genre }}</span>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('albums.show', $album) }}" class="btn btn-sm btn-outline-primary">
                                Ver detalle
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">No hay álbumes registrados aún.</p>
            @endforelse
        </div>

        <div class="mt-4">{{ $albums->links() }}</div>
    </div>
@endsection
