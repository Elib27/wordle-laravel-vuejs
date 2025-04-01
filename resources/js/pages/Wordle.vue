<script setup lang="ts">
import WordleGrid from '@/components/WordleGrid.vue';
import { computed, onMounted, ref } from 'vue';

enum LetterStatus {
    CORRECT_POSITION = 'CORRECT_POSITION',
    WRONG_POSITION = 'WRONG_POSITION',
    NOT_PRESENT = 'NOT_PRESENT',
}

const MAX_ATTEMPTS = 6;
const WORDS_LENGTH = 5;

const wordToGuessId = ref<number | null>(null);
const currentAttempt = ref(0);
const currentLetterIndex = ref(0);
const guessedWords = ref<string[][]>(new Array(MAX_ATTEMPTS).fill('').map(() => new Array(WORDS_LENGTH).fill('')));
const letterStates = ref<LetterStatus[][]>(new Array(MAX_ATTEMPTS).fill('').map(() => new Array(WORDS_LENGTH).fill(null)));

const hasWon = computed(() =>
    letterStates.value[currentAttempt.value - 1 >= 0 ? currentAttempt.value - 1 : 0].reduce(
        (acc, val) => acc && val === LetterStatus.CORRECT_POSITION,
        true,
    ),
);

async function getRandomWordId() {
    const response = await fetch('http://127.0.0.1:8000/api/randomwordid');
    const data = await response.json();
    return data.id as number;
}

onMounted(async () => {
    wordToGuessId.value = await getRandomWordId();
});

async function checkWord(id: number | null, guess: string, attempt: number) {
    if (id === null) return;
    if (currentAttempt.value >= MAX_ATTEMPTS) return;
    if (guessedWords.value[currentAttempt.value].join('').length !== 5) return;

    const response = await fetch(`http://127.0.0.1:8000/api/guessword/${id}`, {
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
        },
        method: 'POST',
        body: JSON.stringify({ guess }),
    });
    const data = await response.json();

    letterStates.value[attempt] = data.guessResult;
}

async function handleKeyboardInput(e: KeyboardEvent) {
    const LETTERS = 'abcdefghijklmnopqrstuvwxyz';
    if (LETTERS.includes(e.key)) {
        if (currentLetterIndex.value >= WORDS_LENGTH) return;
        guessedWords.value[currentAttempt.value][currentLetterIndex.value] = e.key;
        currentLetterIndex.value++;
    } else if (e.key === 'Backspace') {
        currentLetterIndex.value = Math.max(currentLetterIndex.value - 1, 0);
        guessedWords.value[currentAttempt.value][currentLetterIndex.value] = '';
    } else if (e.key === 'Enter') {
        if (currentLetterIndex.value !== WORDS_LENGTH) return;
        await checkWord(wordToGuessId.value, guessedWords.value[currentAttempt.value].join(''), currentAttempt.value);
        currentAttempt.value++;
        currentLetterIndex.value = 0;
    }
}

onMounted(document.addEventListener('keydown', handleKeyboardInput));
</script>

<template>
    <header class="header">
        <button id="restartButton">Restart</button>
        <h1 id="pageTitle">Wordle</h1>
    </header>
    <body class="body">
        <main class="main">
            <WordleGrid :guessedWords :letterStates :currentLetterIndex :currentAttempt />
            <div v-if="hasWon" class="win-message">Tu as trouvé, bravo !</div>
        </main>
    </body>
</template>

<style>
.header {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    height: 60px;
    background-color: rgb(29, 29, 32);
    padding-top: 10px;
    padding-bottom: 10px;
}
#pageTitle {
    font-size: 1.5rem;
    color: white;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 4px;
}
#restartButton {
    position: absolute;
    left: 5%;
}

.body {
    display: flex;
    width: 100%;
    justify-content: space-around;
    background-color: #0e0e0f;
    padding: 50px;
    color: white;
    min-height: calc(100vh - 60px);
}

.main {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 2;
}

.grid {
    pointer-events: none;
    user-select: none;
}

.wordLine {
    display: flex;
    gap: 10px;
    align-items: center;
    margin-bottom: 10px;
}

.cell {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 70px;
    height: 70px;
    font-size: 2rem;
    font-weight: 700;
    text-transform: capitalize;
    border: 3px solid #2f2f2f;
    border-radius: 8px;
    transition: border 0.15s ease-out;
}

.cell.active {
    border-color: #73adff;
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

.win-message {
    font-size: 1.2rem;
    margin-top: 1rem;
}
</style>
