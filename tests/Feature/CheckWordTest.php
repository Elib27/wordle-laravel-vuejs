<?php

use App\Http\Controllers\WordleController;

test('guess correct word returns correct positions', function () {
    $response = $this->post('/api/guessword/1', ['guess' => 'apple']);
    $response->assertStatus(200);
    $response->assertJson([
        'guessResult' => [
            'CORRECT_POSITION',
            'CORRECT_POSITION',
            'CORRECT_POSITION',
            'CORRECT_POSITION',
            'CORRECT_POSITION'
        ],
        'guess' => 'apple'
    ]);
});

test('guess wrong word returns letter statuses', function () {
    $response = $this->post('/api/guessword/1', ['guess' => 'cases']);
    $response->assertStatus(200);
    $response->assertJson([
        'guessResult' => [
            'NOT_PRESENT',
            'WRONG_POSITION',
            'NOT_PRESENT',
            'WRONG_POSITION',
            'NOT_PRESENT'
        ],
        'guess' => 'cases'
    ]);
});

test('guess word with no letter present returns letter not present', function () {
    $response = $this->post('/api/guessword/1', ['guess' => 'osuti']);
    $response->assertStatus(200);
    $response->assertJson([
        'guessResult' => [
            'NOT_PRESENT',
            'NOT_PRESENT',
            'NOT_PRESENT',
            'NOT_PRESENT',
            'NOT_PRESENT'
        ],
        'guess' => 'osuti'
    ]);
});

test('guess word with length different of 5 retyrbs an error', function () {
    $response = $this->post('/api/guessword/1', ['guess' => 'apples']);
    $response->assertStatus(400);
    $response->assertJson([
        'message' => 'the length of the guessed word should be 5'
    ]);
});

