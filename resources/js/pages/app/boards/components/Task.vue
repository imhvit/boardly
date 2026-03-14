<script setup lang="ts">
import { Clock } from 'lucide-vue-next';

const props = defineProps({
    task: { type: Object, required: true },
});

const emit = defineEmits(['dragstart', 'dragend']);
</script>

<template>
    <div draggable="true" @dragstart="emit('dragstart', $event)" @dragend="emit('dragend')"
        class="overflow-hidden p-2 space-y-1 text-sm rounded-md outline-none focus-visible:inset-ring-2 focus-visible:inset-ring-purple-500 shrink-0 bg-neutral-200 cursor-grab active:cursor-grabbing">

        <div class="flex flex-wrap gap-1">
            <span class="px-1.5 text-xs font-medium text-purple-500 bg-purple-200 rounded-sm">{{ task.label }}</span>
        </div>

        <p class="text-neutral-700">{{ task.title }}</p>

        <div>
            <div class="inline-flex gap-1 items-center text-neutral-500">
                <Clock class="size-4" />
                <span class="text-xs font-medium">{{ task.date }}</span>
            </div>
        </div>
    </div>
</template>