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

        $board = Board::create([
            'title' => $request->title,
            'description' => $request->description ?? 'Mi nuevo espacio de trabajo 😊',
        ]);

        $board->users()->attach(Auth::id());

        return redirect()->route('app.boards.index');
    }
    public function show(Request $request, $public_id)
    {
        $view = $request->query('view', 'board');
        $allowed = ['overview', 'board', 'list', 'table', 'timeline'];

        if (!in_array($view, $allowed)) {
            $view = 'board';
        }

        $board = Board::where('public_id', $public_id)->with(['columns' => function ($q) {
            $q->orderBy('position', 'asc')->with(['cards' => function ($query) {
                $query->orderBy('position', 'asc');
            }]);
        }])->firstOrFail();

        return Inertia::render('app/boards/Show', [
            'board' => $board,
            'view' => $view,
            'activeCard' => null,
        ]);
    }
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
