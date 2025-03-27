<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WordleController extends Controller
{

    private $mot = "CONTROLLER";

    public function checkWord(Request $request)
    {
        $guess = $request->input('guess');

        $feedback = [];
        $pendingLetters = [];

        // Detection of well placed letters (correct)
        for ($i = 0; $i < 5; $i++) {
            if ($guess[$i] === $mot[$i]) {
                $feedback[$i] = ['correct'];
            } else {
                $pendingLetters[$mot[$i]] = ($pendingLetters[$mot[$i]] ?? 0) + 1;
            }
        }

        // Dectection of wrong placed (present) and missing letters (missing)
        for ($i = 0; $i < 5; $i++) {
            if (!isset($feedback[$i])) {
                if (!empty($pendingLetters[$guess[$i]])) {
                    $feedback[$i] = ['present'];
                    $pendingLetters[$guess[$i]]--;
                } else {
                    $feedback[$i] = ['missing'];
                }
            }
        }

        return response()->json(['feedback' => $feedback]);
    }
}
