<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;

enum LetterStatus: string
{
    case CORRECT_POSITION = 'CORRECT_POSITION';
    case WRONG_POSITION = 'WRONG_POSITION';
    case NOT_PRESENT = 'NOT_PRESENT';
}

class WordleController extends Controller
{

    public function getRandomWordId(Request $request) {
        $word = Word::all()->random();
        return response()->json(['id' => $word->id], 200);
    }

    const WORD_TO_GUESS = 'apple';
    const WORD_LENGTH = 5;

    public function checkWord(Request $request)
    {

        $id = intval($request->route('id'));
        $guess = $request->input('guess');

        if (strlen($guess) !== self::WORD_LENGTH) {
            return response()->json(['message' => 'the length of the guessed word should be 5'], 400);
        }

        $guessResult = [];
        $pendingLetters = [];

        // Detection of well placed letters (correct)
        for ($i = 0; $i < self::WORD_LENGTH; $i++) {
            if ($guess[$i] === self::WORD_TO_GUESS[$i]) {
                $guessResult[$i] = LetterStatus::CORRECT_POSITION;
            } else {
                $pendingLetters[self::WORD_TO_GUESS[$i]] = ($pendingLetters[self::WORD_TO_GUESS[$i]] ?? 0) + 1;
            }
        }

        // Detection of missplaced (but present) and missing letters
        for ($i = 0; $i < self::WORD_LENGTH; $i++) {
            if (isset($guessResult[$i])) continue;

            if (!empty($pendingLetters[$guess[$i]])) {
                $guessResult[$i] = LetterStatus::WRONG_POSITION;
                $pendingLetters[$guess[$i]]--;
            } else {
                $guessResult[$i] = LetterStatus::NOT_PRESENT;
            }
        }

        return response()->json(['guessResult' => $guessResult, 'guess' => $guess], 200);
    }
}
