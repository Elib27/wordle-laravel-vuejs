<script setup lang="ts">
import { ref } from 'vue';

const wantedWord = Array.from('chest');
const actualAttempt = ref(0);
const words = ref(new Array(5).fill('     '));
const text = ref(' ');

function inputLetter(word: string, letterIndex: number) {
    const wordArray = [...word];
    wordArray[letterIndex] = text.value;
}

function letterInWord(letter: string, word: string, index: number) {
    if (word.includes(letter)) {
        const tempArrayWord = Array.from(word);
        if (tempArrayWord[index] === letter) {
            return 1;
        } else {
            return 0;
        }
    } else {
        return -1;
    }
}

function checkWord(word: string) {
    actualAttempt.value += 1;
}
</script>

<template>
    <header class="header">
        <button id="restartButton">Restart</button>
        <h1 id="pageTitle">Wordle</h1>
    </header>
    <body class="body">
        <main class="main">
            <div v-for="word in words" :key="word" class="wordLine">
                <input @input="inputLetter(word, letterIndex)" v-for="(letter, letterIndex) in word" :key="letterIndex" class="cell" maxlength="1" />
                <p>{{ text }}</p>
            </div>
            <button @click="checkWord(word)" class="submitButton">Submit</button>
        </main>
        <aside class="aside"></aside>
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
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
    background-color: black;
    padding: 20px;
    color: white;
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

.submitButton {
    border: 1px solid white;
    border-radius: 10%;
}
</style>
