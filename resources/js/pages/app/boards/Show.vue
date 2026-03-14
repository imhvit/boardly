<script setup>
import { useRecentBoards } from '@/composables/useResentBoards';
import AppLayout from '@/layouts/AppLayout.vue';
import { onMounted } from 'vue';
import Header from './components/Header.vue';
import CardContainer from './components/CardContainer.vue';
import { Head } from '@inertiajs/vue3';

const { addRecentBoard } = useRecentBoards();

defineOptions({ layout: AppLayout });

const props = defineProps({
    board: {
        type: Object,
        required: true
    },
    view: {
        type: String,
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

    <Head :title="board.title" />
    <Header :board-id="board.public_id" :title="board.title" :description="board.description" :view="view" />
    <div class="flex overflow-x-auto gap-2 px-4 pb-2 h-full pt-34">
        <CardContainer />
    </div>
</template>