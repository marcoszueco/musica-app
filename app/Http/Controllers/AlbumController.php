<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Http\Requests\StoreAlbumRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function index(): View
    {
        $albums = Album::orderByDesc('created_at')->paginate(10);
        return view('albums.index', compact('albums'));
    }

    public function create(): View
    {
        return view('albums.create');
    }

    public function store(StoreAlbumRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Album::create($data);

        return redirect()->route('albums.index')
            ->with('success', 'Álbum creado correctamente.');
    }

    public function show(Album $album): View
    {
        return view('albums.show', compact('album'));
    }

    public function edit(Album $album): View
    {
        $this->authorizeAccess($album);
        return view('albums.edit', compact('album'));
    }

    public function update(StoreAlbumRequest $request, Album $album): RedirectResponse
    {
        $this->authorizeAccess($album);

        $data = $request->validated();

        if ($request->hasFile('cover')) {
            if ($album->cover) {
                Storage::disk('public')->delete($album->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $album->update($data);

        return redirect()->route('albums.show', $album)
            ->with('success', 'Álbum actualizado correctamente.');
    }

    public function destroy(Album $album): RedirectResponse
    {
        $this->authorizeAccess($album);

        if ($album->cover) {
            Storage::disk('public')->delete($album->cover);
        }

        $album->delete();

        return redirect()->route('albums.index')
            ->with('success', 'Álbum eliminado.');
    }

    public function search(Request $request):View{
        $query = Album::query();
        $query -> when(request('filter_by')=='title',function ($q){
            return $q->where('title', 'like', '%'.request('textTitle').'%')->get();
        });
        $query -> when(request('filter_by')=='genre',function ($q){
            return $q->where('genre', 'like', '%'.request('textGenre').'%')->get();
        });
        $query -> when(request('filter_by')=='year',function ($q){
            return $q->where('release_year', '>', request('startYear'))->where('release_year', '<', request('endYear'))->get();
        });
        $query -> when(request('filter_by')=='rating',function ($q){
            return $q->where('average_rating', '>=', request('searchRating'))->get();
        });
        $query -> when(request('filter_by')=='order',function ($q){
            if (request('order')=='title') {
                $q=$q->orderBy('title');
            }elseif (request('order')=='year') {
                $q=$q->orderByDesc('release_year');
            }elseif (request('order')=='rating') {
                $q=$q->orderByDesc('average_rating');
            }
            return $q->get();

        });


        // Filtros con when()
        $albums = $query->paginate(10)->withQueryString();
        $genres = Album::distinct()->orderBy('genre')->pluck('genre');
        return view('albums.search', compact('albums', 'genres'));
    }

    private function authorizeAccess(Album $album): void
    {
        if (auth()->id() !== $album->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }
    }
}
