<?php

namespace App\Http\Controllers;

use App\Models\ReadingList;
use App\Services\ComicVineService;
use Illuminate\Http\Request;

class ReadingListController extends Controller
{
    public function __construct(private ComicVineService $cv) {}

    public function index(Request $request)
    {
        $tab = $request->input('tab', 'all');
        $sort = $request->input('sort', 'recent');

        $query = ReadingList::where('user_id', auth()->id());

        match ($tab) {
            'unread'    => $query->where('status', 'unread'),
            'reading'   => $query->where('status', 'reading'),
            'read'      => $query->where('status', 'read'),
            'favorites' => $query->where('is_favorite', true),
            default     => null,
        };

        match ($sort) {
            'title'     => $query->orderBy('title'),
            'published' => $query->orderBy('published_at', 'desc'),
            'status'    => $query->orderBy('status'),
            default     => $query->latest(),
        };

        $items = $query->get();

        $stats = [
            'all'       => ReadingList::where('user_id', auth()->id())->count(),
            'unread'    => ReadingList::where('user_id', auth()->id())->where('status', 'unread')->count(),
            'reading'   => ReadingList::where('user_id', auth()->id())->where('status', 'reading')->count(),
            'read'      => ReadingList::where('user_id', auth()->id())->where('status', 'read')->count(),
            'favorites' => ReadingList::where('user_id', auth()->id())->where('is_favorite', true)->count(),
        ];

        return view('reading_list', compact('items', 'tab', 'sort', 'stats'));
    }

    public function add(Request $request)
    {
        $comicId = $request->input('comic_id');

        $existing = ReadingList::where('user_id', auth()->id())
            ->where('comic_id', $comicId)
            ->first();

        if ($existing) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Ya está en tu biblioteca', 'item' => $existing]);
            }
            return redirect()->back()->with('info', 'Este cómic ya está en tu biblioteca.');
        }

        $comic = $this->cv->getIssue((int) $comicId);

        $item = ReadingList::create([
            'user_id'       => auth()->id(),
            'comic_id'      => $comicId,
            'title'         => $comic['title'] ?? null,
            'description'   => $comic['description'] ?? null,
            'thumbnail_url' => $comic['thumbnail_url'] ?? null,
            'page_count'    => $comic['page_count'] ?? null,
            'published_at'  => $comic['cover_date'] ?? null,
            'status'        => 'unread',
            'is_favorite'   => false,
            'characters'    => $comic ? collect($comic['characters'])->pluck('name')->take(5)->all() : null,
            'creators'      => $comic ? collect($comic['creators'])->take(5)->all() : null,
            'marvel_url'    => $comic['site_url'] ?? null,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Añadido a tu biblioteca', 'item' => $item]);
        }

        return redirect()->back()->with('success', '¡Añadido a tu biblioteca!');
    }

    public function update(Request $request, $comicId)
    {
        $item = ReadingList::where('user_id', auth()->id())
            ->where('comic_id', $comicId)
            ->firstOrFail();

        if ($request->has('status')) {
            $item->status = $request->input('status');
        }
        if ($request->has('is_favorite')) {
            $item->is_favorite = (bool) $request->input('is_favorite');
        }

        $item->save();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Actualizado', 'item' => $item]);
        }

        return redirect()->back()->with('success', 'Estado actualizado.');
    }

    public function toggleFavorite(Request $request, $comicId)
    {
        $item = ReadingList::where('user_id', auth()->id())
            ->where('comic_id', $comicId)
            ->firstOrFail();

        $item->is_favorite = !$item->is_favorite;
        $item->save();

        if ($request->expectsJson()) {
            return response()->json(['is_favorite' => $item->is_favorite]);
        }

        return redirect()->back();
    }

    public function destroy($comicId)
    {
        ReadingList::where('user_id', auth()->id())
            ->where('comic_id', $comicId)
            ->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Eliminado de tu biblioteca']);
        }

        return redirect()->back()->with('success', 'Eliminado de tu biblioteca.');
    }
}
