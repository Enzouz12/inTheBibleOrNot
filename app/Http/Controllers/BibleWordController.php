<?php

namespace App\Http\Controllers;

use App\Models\BibleWord;
use Illuminate\Http\Request;

class BibleWordController extends Controller
{
    public function check(Request $request)
    {
        $request->validate([
            'words' => 'required|array',
            'words.*' => 'string',
        ]);

        $words = array_map('mb_strtolower', $request->input('words'));

        $found = BibleWord::whereIn('word', $words)
            ->pluck('word')
            ->toArray();

        $results = [];
        foreach ($words as $word) {
            $results[$word] = in_array($word, $found);
        }

        $total = count($results);
        $inBible = count(array_filter($results));

        return response()->json([
            'results' => $results,
            'stats' => [
                'total' => $total,
                'inBible' => $inBible,
                'notInBible' => $total - $inBible,
            ],
        ]);
    }
}
