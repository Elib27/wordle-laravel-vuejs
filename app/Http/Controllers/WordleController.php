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
        $lettresRestantes = [];

        // Détection des lettres bien placées (correct)
        for ($i = 0; $i < 5; $i++) {
            if ($guess[$i] === $mot[$i]) {
                $feedback[$i] = ['correct'];
            } else {
                $lettresRestantes[$mot[$i]] = ($lettresRestantes[$mot[$i]] ?? 0) + 1;
            }
        }

        // Détection des lettres mal placées (present) et absentes
        for ($i = 0; $i < 5; $i++) {
            if (!isset($feedback[$i])) {
                if (!empty($lettresRestantes[$guess[$i]])) {
                    $feedback[$i] = ['present'];
                    $lettresRestantes[$guess[$i]]--;
                } else {
                    $feedback[$i] = ['absent'];
                }
            }
        }

        return response()->json(['feedback' => $feedback]);
    }
}
