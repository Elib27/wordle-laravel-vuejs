<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Word;

class WordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $words = [
            'arbre',
            'avion',
            'beaux',
            'bleus',
            'boire',
            'brave',
            'chien',
            'clair',
            'corps',
            'croix',
            'danse',
            'dents',
            'doute',
            'eauxe',
            'ennui',
            'ferme',
            'fille',
            'flute',
            'froid',
            'fruit',
            'gants',
            'gazon',
            'glace',
            'grive',
            'hiver',
            'horas',
            'image',
            'jambe',
            'jeudi',
            'jouer',
            'joute',
            'jupes',
            'lente',
            'lourd',
            'luire',
            'lutte',
            'mains',
            'maman',
            'mardi',
            'mener',
            'mètre',
            'mielx',
            'mouet',
            'nager',
            'noire',
            'noter',
            'noyau',
            'ombre',
            'orage',
            'osier',
            'pains',
            'pluie',
            'poids',
            'pomme',
            'poule',
            'prier',
            'quais',
            'quint',
            'races',
            'ranch',
            'rater',
            'repos',
            'retra',
            'rivet',
            'rouge',
            'rural',
            'sable',
            'saint',
            'seaux',
            'seuil',
            'sirop',
            'singe',
            'somme',
            'songe',
            'soupe',
            'sport',
            'sucre',
            'table',
            'talon',
            'temps',
            'terre',
            'train',
            'trame',
            'tulle',
            'union',
            'utile',
            'vague',
            'valet',
            'vente',
            'vieux',
            'ville',
            'votre',
            'wagon',
            'zeste',
            'zèbre',
        ];

        foreach($words as $word) {
            Word::create(['word' => $word]);
        }
    }
}
