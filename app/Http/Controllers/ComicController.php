<?php

namespace App\Http\Controllers;

use App\Services\ComicVineService;
use App\Models\ReadingList;
use Illuminate\Http\Request;

class ComicController extends Controller
{
    public function __construct(private ComicVineService $cv) {}

    public function index()
    {
        $result   = $this->cv->getIssues(12, 0);
        $trending = $result['comics'] ?? [];

        $recentResult = $this->cv->getIssues(12, 12);
        $recent = $recentResult['comics'] ?? [];

        $inProgress = collect();
        if (auth()->check()) {
            $inProgress = ReadingList::where('user_id', auth()->id())
                ->where('status', 'reading')
                ->latest()
                ->take(8)
                ->get();
        }

        $apiConfigured = $this->cv->isConfigured();

        return view('dashboard', compact('trending', 'recent', 'inProgress', 'apiConfigured'));
    }

    public function explore(Request $request)
    {
        $query  = trim($request->input('search', ''));
        $offset = (int) $request->input('offset', 0);
        $comics = [];
        $total  = 0;

        if ($query !== '') {
            $result = $this->cv->searchIssues($query, 20, $offset);
        } else {
            $result = $this->cv->getIssues(24, $offset);
        }
        $comics = $result['comics'] ?? [];
        $total  = $result['total'] ?? 0;

        if ($request->expectsJson()) {
            return response()->json(['comics' => $comics, 'total' => $total]);
        }

        return view('explore', compact('comics', 'query', 'total', 'offset'));
    }

    public function show(int $id)
    {
        $comic = $this->cv->getIssue($id);

        if (!$comic) {
            abort(404);
        }

        $inLibrary = null;
        if (auth()->check()) {
            $inLibrary = ReadingList::where('user_id', auth()->id())
                ->where('comic_id', $id)
                ->first();
        }

        $related = $this->cv->getIssues(6, 0);
        $related = $related['comics'] ?? [];

        return view('comic', compact('comic', 'inLibrary', 'related'));
    }
}
