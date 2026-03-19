<script setup>
import { useRecentBoards } from '@/composables/useRecentBoards';
import { useDrag } from '@/composables/useDrag';
import AppLayout from '@/layouts/AppLayout.vue';
import { onMounted } from 'vue';
import Header from './components/Header.vue';
import CardContainer from './components/CardContainer.vue';
import { Head } from '@inertiajs/vue3';


const props = defineProps({
    board: Object,
    view: String,
    activeCard: null,
});

const { addRecentBoard } = useRecentBoards();
const { columns, placeholder, onDragStart, onCardDragOver, onColumnDragOver, onDrop, resetDrag } = useDrag(props.board.columns);

onMounted(() => {
    addRecentBoard({ public_id: props.board.public_id, slug: props.board.title });
});
</script>

<template>

    <Head :title="board.title" />
    <AppLayout>
        <Header :public-id="board.public_id" :slug="board.title" :description="board.description" :view="view" />

        <div class="flex h-full gap-2 px-4 pb-2 overflow-x-auto pt-34" @dragover.prevent @drop.prevent="onDrop"
            @dragend="resetDrag">

            <template v-for="(column, index) in columns" :key="column.id">
                <div v-if="placeholder.type === 'column' && placeholder.index === index"
                    :style="{ width: placeholder.width + 'px' }"
                    class="h-10 transition-all bg-purple-200 border border-purple-400 border-dashed rounded-xl shrink-0">
                </div>
                <CardContainer :column="column" :placeholder="placeholder" @start-drag="onDragStart"
                    @drag-end="resetDrag" @card-hover="onCardDragOver" @col-hover="onColumnDragOver"
                    @drop-item="onDrop" />
            </template>

            <div v-if="placeholder.type === 'column' && placeholder.index === columns.length"
                :style="{ width: placeholder.width + 'px' }"
                class="h-10 transition-all bg-purple-200 border border-purple-400 border-dashed rounded-xl shrink-0">
            </div>
        </div>
    </AppLayout>
</template>