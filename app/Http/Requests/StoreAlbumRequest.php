<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlbumRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'max:200'],
            'artist'       => ['required', 'string', 'max:200'],
            'genre'        => ['required', 'string', 'max:100'],
            'release_year' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'record_label' => ['nullable', 'string', 'max:150'],
            'description'  => ['nullable', 'string', 'max:2000'],
            'cover'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'        => 'El título del álbum es obligatorio.',
            'artist.required'       => 'El nombre del artista es obligatorio.',
            'genre.required'        => 'El género musical es obligatorio.',
            'release_year.required' => 'El año de lanzamiento es obligatorio.',
            'release_year.min'      => 'El año no puede ser anterior a 1900.',
            'cover.image'           => 'La portada debe ser una imagen válida.',
            'cover.max'             => 'La portada no puede superar los 2 MB.',
        ];
    }
}
