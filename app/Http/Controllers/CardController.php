<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function reorder(Request $request)
    {
        $request->validate([
            'column_id' => 'required|exists:columns,id',
            'positions' => 'required|array',
            'positions.*.id' => 'required|exists:cards,id', // [!] Validación estricta añadida
            'positions.*.position' => 'required|integer',
        ]);

        $columnId = $request->column_id;
        $positions = $request->positions;

        DB::transaction(function () use ($columnId, $positions) {
            $cases = [];
            $params = [];
            $ids = [];

            foreach ($positions as $item) {
                $cases[] = "WHEN id = ? THEN ?";
                $params[] = $item['id'];
                $params[] = $item['position'];
                $ids[] = $item['id'];
            }

            $idsString = implode(',', array_fill(0, count($ids), '?'));

            // [!] CORRECCIÓN CRÍTICA DE ORDEN DE BINDINGS:
            // 1. $params (Para los ? del CASE)
            // 2. [$columnId] (Para el ? de column_id)
            // 3. $ids (Para los ? del WHERE IN)
            $finalParams = array_merge($params, [$columnId], $ids);

            // Agregamos 'ELSE position' por seguridad estructural
            DB::update("
        UPDATE cards 
        SET position = CASE " . implode(' ', $cases) . " ELSE position END,
            column_id = ?
        WHERE id IN ($idsString)
    ", $finalParams);
        });

        return back();
    }

    // public function store(Request $request)
    // {
    //     $maxPosition = Card::where('column_id', $request->column_id)->max('position');

    //     Card::create([
    //         'title' => $request->title,
    //         'column_id' => $request->column_id,
    //         'position' => $maxPosition + 1, // La pone al final
    //         'owner_id' => auth()->id(),
    //     ]);

    //     return back();
    // }
}
