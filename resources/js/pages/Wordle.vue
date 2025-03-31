<script setup lang="ts">
import { ref } from 'vue';

enum LetterStatus {
    CORRECT_POSITION = 'CORRECT_POSITION',
    WRONG_POSITION = 'WRONG_POSITION',
    NOT_PRESENT = 'NOT_PRESENT',
}

const maxAttempt = 6;
const actualAttempt = ref(0);
const words = ref<string[][]>(new Array(maxAttempt).fill('').map(() => new Array(5).fill('')));
const letterStates = ref(new Array(maxAttempt).fill('').map(() => new Array(5).fill(null)));

function letterStateToCellClass(letterStatus: LetterStatus) {
    switch (letterStatus) {
        case LetterStatus.CORRECT_POSITION:
            return 'cell_correct_position';
        case LetterStatus.WRONG_POSITION:
            return 'cell_wrong_position';
        default:
            return '';
    }
}

async function checkWord(word: string) {
    const response = await fetch('http://127.0.0.1:8000/api/guessword/1', {
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
        },
        method: 'POST',
        body: JSON.stringify({ guess: word }),
    });
    const data = await response.json();
    const presenceArray = data.guessResult;
    letterStates.value[actualAttempt.value] = presenceArray;
    actualAttempt.value = actualAttempt.value < maxAttempt - 1 ? actualAttempt.value + 1 : 0;
}
</script>

<template>
    <header class="header">
        <button id="restartButton">Restart</button>
        <h1 id="pageTitle">Wordle</h1>
    </header>
    <body class="body">
        <main class="main">
            <div v-for="(word, wordIndex) in words" :key="wordIndex" class="wordLine">
                <input
                    v-for="(letter, letterIndex) in word"
                    :key="letterIndex"
                    v-model="words[wordIndex][letterIndex]"
                    :disabled="wordIndex !== actualAttempt"
                    :class="`cell ${letterStateToCellClass(letterStates[wordIndex][letterIndex])}`"
                    maxlength="1"
                />
            </div>
            <button @click="() => checkWord(words[actualAttempt].join(''))" class="submitButton">Submit</button>
        </main>
        <aside class="aside">
            <h2 id="attemptDisplay">Attempt : {{ actualAttempt }}</h2>
        </aside>
    </body>
</template>

<style>
.header {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    background-color: gray;
    padding-top: 10px;
    padding-bottom: 10px;
}
#pageTitle {
    font-size: 2rem;
}
#restartButton {
    position: absolute;
    left: 5%;
}

.body {
    display: flex;
    width: 100%;
    justify-content: space-around;
    background-color: black;
    padding: 50px;
    color: white;
    min-height: 100vh;
}

.main {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 2;
}

.aside {
    flex: 1;
    align-content: center;
}

.wordLine {
    display: flex;
    gap: 15px;
    align-items: center;
    margin-bottom: 15px;
}

.cell {
    width: 75px;
    height: 75px;
    text-align: center;
    font-size: 2rem;
    text-transform: capitalize;
    background-color: black;
    border: 2px solid gray;
    border-radius: 10%;
}

.cell_correct_position {
    background-color: green;
}

.cell_wrong_position {
    background-color: orange;
}

.submitButton {
    border: 1px solid white;
    border-radius: 10%;
}
</style>
