<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BoardController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
        ]);

        Board::create([
            'title' => $request->title,
            'owner_id' => Auth::user()->id,
        ]);

        return redirect()->route('app.boards.index');
    }
    public function show(string $board)
    {
        $board = Board::where('public_id', $board)->first();
        return Inertia::render('app/boards/Show', [
            'board' => $board
        ]);
    }
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
