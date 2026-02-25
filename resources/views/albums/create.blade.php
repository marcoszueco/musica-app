@extends('layouts.app')

@section('content')
    <div class="container py-4" style="max-width:700px">
        <h1 class="mb-4">Añadir álbum</h1>

        <form action="{{ route('albums.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Título *</label>
                <input type="text" name="title"
                       class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title') }}">
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Artista *</label>
                <input type="text" name="artist"
                       class="form-control @error('artist') is-invalid @enderror"
                       value="{{ old('artist') }}">
                @error('artist') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Género *</label>
                    <input type="text" name="genre"
                           class="form-control @error('genre') is-invalid @enderror"
                           value="{{ old('genre') }}">
                    @error('genre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col mb-3">
                    <label class="form-label">Año de lanzamiento *</label>
                    <input type="number" name="release_year"
                           class="form-control @error('release_year') is-invalid @enderror"
                           value="{{ old('release_year') }}" min="1900" max="{{ date('Y') }}">
                    @error('release_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Discográfica</label>
                <input type="text" name="record_label" class="form-control"
                       value="{{ old('record_label') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Portada (imagen)</label>
                <input type="file" name="cover"
                       class="form-control @error('cover') is-invalid @enderror"
                       accept="image/*">
                @error('cover') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Guardar álbum</button>
                <a href="{{ route('albums.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
