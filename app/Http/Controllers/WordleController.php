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
        for ($i = 0; $i < 5; $i++) {
            if ($guess[$i] === $mot[$i]) {
                $feedback[] = ['lettre' => $guess[$i], 'etat' => 'correct'];
            } elseif (str_contains($mot, $guess[$i])) {
                $feedback[] = ['lettre' => $guess[$i], 'etat' => 'present'];
            } else {
                $feedback[] = ['lettre' => $guess[$i], 'etat' => 'absent'];
            }
        }

        return response()->json(['feedback' => $feedback]);
    }
}
