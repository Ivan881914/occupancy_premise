<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class InputController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $time = $request->input('time');
        $diff = $request->input('diff');

        Log::info('Полученные данные', ['time' => $time, 'diff' => $diff]);

        // Вставляем данные в таблицу
        DB::table('occupancy')->insert([
            'timestamp' => $time,
            'diff' => $diff,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }
}
