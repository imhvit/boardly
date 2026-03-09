<script setup lang="ts">
import { Share2 } from 'lucide-vue-next';
import { UserPlus } from 'lucide-vue-next';

</script>

<template>
    <header class="flex flex-col space-y-4">
        <div class="flex gap-4 justify-between items-center">
            <aside>
                <h1 class="text-xl font-semibold text-purple-500">Board title</h1>
                <p class="text-sm text-neutral-500">Board description</p>
            </aside>
            <div class="flex gap-4 items-center">
                <div>
                    <div
                        class="inline-flex justify-center items-center rounded-full bg-neutral-300 size-8 text-neutral-500">
                        Y
                    </div>
                </div>
                <div class="flex gap-2 items-center">
                    <button
                        class="inline-flex gap-2 items-center px-4 py-2 text-sm font-medium text-white bg-purple-500 rounded-xl cursor-pointer hover:bg-purple-600">
                        <UserPlus class="size-4" />
                        <span>Invitar</span>
                    </button>
                    <button
                        class="inline-flex gap-2 items-center px-4 py-2 text-sm font-medium rounded-xl border cursor-pointer border-neutral-400/30 bg-neutral-300 hover:bg-neutral-400/30 text-neutral-700">
                        <Share2 class="size-4" />
                        <span>Compartir</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="flex gap-4 justify-between items-center">
            <ul class="flex gap-4 items-center">
                <li>
                    <button>Overview</button>
                </li>
                <li>
                    <button>Board</button>
                </li>
                <li>
                    <button>List</button>
                </li>
                <li>
                    <button>Table</button>
                </li>
                <li>
                    <button>Timeline</button>
                </li>
            </ul>
            <ul class="flex gap-4 items-center">
                <li>
                    <button>Filtrar</button>
                </li>
                <li>
                    <button>Agrupar por</button>
                </li>
                <li>
                    <button>Ordenar por</button>
                </li>
            </ul>
        </div>
    </header>
</template>