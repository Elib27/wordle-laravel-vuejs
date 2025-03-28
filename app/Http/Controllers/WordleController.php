<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WordleController extends Controller
{

    const WORD_TO_GUESS = 'apple';
    const WORD_LENGTH = 5;

    public function checkWord(Request $request)
    {


        $id = intval($request->route('id'));
        $guess = $request->input('guess');

        if (strlen($guess) !== self::WORD_LENGTH) {
            return response()->json(['error' => 'the length of the guessed word should be 5'], 400);
        }

        $feedback = [];
        $pendingLetters = [];

        // Detection of well placed letters (correct)
        for ($i = 0; $i < self::WORD_LENGTH; $i++) {
            if ($guess[$i] === self::WORD_TO_GUESS[$i]) {
                $feedback[$i] = ['correct'];
            } else {
                $pendingLetters[self::WORD_TO_GUESS[$i]] = ($pendingLetters[self::WORD_TO_GUESS[$i]] ?? 0) + 1;
            }
        }

        // Detection of missplaced (but present) and missing letters
        for ($i = 0; $i < self::WORD_LENGTH; $i++) {
            if (isset($feedback[$i])) continue;

            if (!empty($pendingLetters[$guess[$i]])) {
                $feedback[$i] = ['present'];
                $pendingLetters[$guess[$i]]--;
            } else {
                $feedback[$i] = ['missing'];
            }
        }

        return response()->json(['feedback' => $feedback, 'guess' => $guess], 200);
    }
}
