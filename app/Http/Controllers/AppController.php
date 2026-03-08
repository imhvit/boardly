<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Inertia\Inertia;

class AppController extends Controller
{
    public function index()
    {
        return Inertia::render('app/Index');
    }

    public function boards()
    {
        $boards = Board::take(10)->get();
        return Inertia::render('app/boards/Index', [
            'boards' => $boards,
        ]);
    }

    public function templates()
    {
        return Inertia::render('app/Templates');
    }
}
