<script setup lang="ts">
enum LetterStatus {
    CORRECT_POSITION = 'CORRECT_POSITION',
    WRONG_POSITION = 'WRONG_POSITION',
    NOT_PRESENT = 'NOT_PRESENT',
}

interface WordleGridProps {
    guessedWords: string[][];
    letterStates: LetterStatus[][];
    currentLetterIndex: number;
    currentAttempt: number;
}

const props = defineProps<WordleGridProps>();

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
</script>

<template>
    <div class="grid">
        <div v-for="(word, wordIndex) in props.guessedWords" :key="wordIndex" class="wordLine">
            <div
                v-for="(letter, letterIndex) in word"
                :key="letterIndex"
                :class="`cell ${letterStateToCellClass(props.letterStates[wordIndex][letterIndex])} ${letterIndex === props.currentLetterIndex && wordIndex === props.currentAttempt ? 'active' : ''}`"
            >
                {{ letter }}
            </div>
        </div>
    </div>
</template>
