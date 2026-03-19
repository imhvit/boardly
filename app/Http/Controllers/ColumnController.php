<?php

namespace App\Http\Controllers;

use App\Models\Column;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColumnController extends Controller
{
    public function reorder(Request $request)
    {
        $request->validate([
            'positions' => 'required|array',
            'positions.*.id' => 'required|exists:columns,id',
            'positions.*.position' => 'required|integer',
        ]);

        DB::transaction(function () use ($request) {
            $cases = [];
            $params = [];
            $ids = [];

            foreach ($request->positions as $item) {
                $cases[] = "WHEN id = ? THEN ?";
                $params[] = $item['id'];
                $params[] = $item['position'];
                $ids[] = $item['id'];
            }

            $idsString = implode(',', array_fill(0, count($ids), '?'));
            $params = array_merge($params, $ids);

            // Una sola ejecución para actualizar todo el tablero
            DB::update("
                UPDATE columns 
                SET position = CASE " . implode(' ', $cases) . " END
                WHERE id IN ($idsString)
            ", $params);
        });

        return back();
    }
}
