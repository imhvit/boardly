<script setup>
import Task from "./Task.vue";

import { Plus, MoreHorizontal } from "lucide-vue-next";
</script>

<template>
    <div v-for="a in 3" :key="a"
        class="flex select-none flex-col gap-1 p-2 shadow-md w-[250px] shrink-0 h-max max-h-[calc(100vh-12rem)] bg-neutral-100 rounded-xl">
        <div class="flex justify-between items-center cursor-grab">
            <div class="flex flex-1 gap-1 items-center">
                <h2 class="px-2 text-sm font-medium text-neutral-700">To do</h2>

                <span
                    class="inline-flex justify-center items-center w-4 h-3 text-xs font-medium rounded-full select-none text-neutral-700 bg-neutral-200">
                    {{ a }}
                </span>
            </div>

            <div class="flex gap-1 items-center text-neutral-500">
                <button
                    class="inline-flex justify-center items-center rounded-full cursor-pointer size-5 hover:bg-neutral-200">
                    <Plus class="size-4" />
                </button>

                <button
                    class="inline-flex justify-center items-center rounded-full cursor-pointer size-5 hover:bg-neutral-200">
                    <MoreHorizontal class="size-4" />
                </button>
            </div>
        </div>

        <div class="flex overflow-y-auto flex-col gap-2">
            <Task />
        </div>
    </div>
</template>
