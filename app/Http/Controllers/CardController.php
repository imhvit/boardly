<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CardController extends Controller
{
    public function show(Card $card)
    {
        $card->load('column', 'owner', 'users');
        $board = $card->column->board()->with('columns.cards')->firstOrFail();

        return Inertia::render('Board/Show', [
            'board' => $board,
            'activeCard' => $card,
        ]);
    }
}
