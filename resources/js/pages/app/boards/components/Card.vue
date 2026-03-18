<script setup lang="ts">
import { Clock } from 'lucide-vue-next';

defineProps({
    card: { type: Object, required: true },
});

const emit = defineEmits(['dragstart', 'dragend']);
</script>

<template>
    <div draggable="true" @dragstart="emit('dragstart', $event)" @dragend="emit('dragend', $event)"
        class="p-2 space-y-1 overflow-hidden text-sm rounded-md outline-none focus-visible:inset-ring-2 focus-visible:inset-ring-purple-500 shrink-0 bg-neutral-200 cursor-grab active:cursor-grabbing">

        <div class="flex flex-wrap gap-1">
            <span v-if="card.labels && card.labels.length" v-for="label in card.labels" :key="label.id"
                class="px-1.5 text-xs font-medium text-purple-500 bg-purple-200 rounded-sm">
                {{ label.name }}
            </span>
        </div>

        <p class="text-neutral-700">{{ card.title }}</p>

        <div>
            <div class="inline-flex items-center gap-1 text-neutral-500">
                <Clock class="size-4" />
                <span class="text-xs font-medium">{{ card.date }}</span>
            </div>
        </div>
    </div>
</template>