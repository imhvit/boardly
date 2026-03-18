<script setup>
import Card from "./Card.vue";
import { Plus, MoreHorizontal } from "lucide-vue-next";

defineProps({
    column: Object,
    placeholder: Object
});

const emit = defineEmits(['start-drag', 'card-hover', 'col-hover', 'drop-item', 'drag-end']);
</script>

<template>
    <div draggable="true" @dragstart.stop="emit('start-drag', $event, column, 'column')"
        @dragend.stop="emit('drag-end', $event)" @dragover.prevent.stop="emit('col-hover', $event, column.id)"
        @drop.prevent.stop="emit('drop-item')"
        class="flex select-none flex-col gap-1 p-2 shadow-md w-[250px] shrink-0 h-max max-h-[calc(100vh-12rem)] bg-neutral-100 rounded-xl cursor-grab active:cursor-grabbing">

        <div class="flex items-center justify-between">
            <div class="flex items-center flex-1 gap-1">
                <h2 class="px-2 text-sm font-medium text-neutral-700">{{ column.title }}</h2>
                <span
                    class="inline-flex items-center justify-center w-4 h-3 text-xs font-medium rounded-full select-none text-neutral-700 bg-neutral-200">
                    {{ column.cards.length }}
                </span>
            </div>

            <div class="flex items-center gap-1 text-neutral-500">
                <button
                    class="inline-flex items-center justify-center rounded-full cursor-pointer size-5 hover:bg-neutral-200">
                    <Plus class="size-4" />
                </button>
                <button
                    class="inline-flex items-center justify-center rounded-full cursor-pointer size-5 hover:bg-neutral-200">
                    <MoreHorizontal class="size-4" />
                </button>
            </div>
        </div>

        <div class="flex overflow-y-auto flex-col gap-2 min-h-[40px] cursor-default">
            <template v-for="(card, index) in column.cards" :key="card.id">
                <div v-if="placeholder.type === 'card' && placeholder.colId === column.id && placeholder.index === index"
                    :style="{ height: placeholder.height + 'px' }"
                    class="w-full transition-all bg-purple-200 border border-purple-400 border-dashed rounded-md">
                </div>

                <Card :card="card" @dragstart.stop="emit('start-drag', $event, card, 'card', column.id)"
                    @dragend.stop="emit('drag-end', $event)"
                    @dragover.prevent.stop="emit('card-hover', $event, index, column.id)" />
            </template>

            <div v-if="placeholder.type === 'card' && placeholder.colId === column.id && placeholder.index === column.cards.length"
                :style="{ height: placeholder.height + 'px' }"
                class="w-full transition-all bg-purple-200 border border-purple-400 border-dashed rounded-md">
            </div>
        </div>
    </div>
</template>