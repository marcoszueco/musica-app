@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-3">
                @if($album->cover)
                    <img src="{{ Storage::url($album->cover) }}"
                         class="img-fluid rounded shadow"
                         alt="{{ $album->title }}">
                @else
                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                         style="height:200px">
                        <span class="text-white fs-1">🎵</span>
                    </div>
                @endif
            </div>
            <div class="col-md-9">
                <h1>{{ $album->title }}</h1>
                <p class="text-muted fs-5">{{ $album->artist }}</p>
                <p><strong>Género:</strong> {{ $album->genre }}</p>
                <p><strong>Año:</strong> {{ $album->release_year }}</p>
                @if($album->record_label)
                    <p><strong>Discográfica:</strong> {{ $album->record_label }}</p>
                @endif
                @if($album->description)
                    <p class="mt-3">{{ $album->description }}</p>
                @endif

                @auth
                    @if(auth()->id() === $album->user_id || auth()->user()->isAdmin())
                        <div class="mt-4 d-flex gap-2">
                            <a href="{{ route('albums.edit', $album) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('albums.destroy', $album) }}" method="POST"
                                  onsubmit="return confirm('¿Seguro que quieres eliminar este álbum?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
@endsection
