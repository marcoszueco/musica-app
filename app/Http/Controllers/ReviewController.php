<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Método 1
    public function index()
    {
        $albums = Album::all()->paginate(10);
        return view('albums.index', compact('albums'));
    }

    // Método 2
    public function update(Request $request, Album $album)
    {
        if (auth()->id() !== $album->user_id || auth()->user()->isAdmin()) {
            abort(403);
        }

        $album->update($request->validated());

        return redirect()->route('albums.show', $album)
            ->with('success', 'Álbum actualizado.');
    }

    // Método 3
    public function show(Album $album)
    {
        $reviews = $album->reviews()->orderBy('created_at', 'desc')->get();
        return view('albums.show', [$reviews]);
    }
}
