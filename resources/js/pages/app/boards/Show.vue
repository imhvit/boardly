<script setup>
import { useRecentBoards } from '@/composables/useResentBoards';
import AppLayout from '@/layouts/AppLayout.vue';
import { onMounted } from 'vue';
import Header from './components/Header.vue';

const { addRecentBoard } = useRecentBoards();

defineOptions({ layout: AppLayout });

const props = defineProps({
    board: {
        type: Object,
        required: true
    }
});

onMounted(() => {
    addRecentBoard({
        id: props.board.public_id,
        slug: props.board.title
    });
});
</script>
<template>
    <Header />
    <h1>Este es el board: {{ board.title }} - {{ board.public_id }}</h1>
</template>