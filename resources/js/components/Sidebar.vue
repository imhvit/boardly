<script setup>
import BoardlyIcon from '@/icons/svg/BoardlyIcon.vue';
import { Link } from '@inertiajs/vue3';
import { SIDEBAR_LINKS } from '@/consts/sidebar';
import { useRecentBoards } from '@/composables/useRecentBoards';

const { recentBoards } = useRecentBoards();
</script>

<template>
    <div class="fixed w-[250px] h-full z-99 select-none">
        <div class="h-full border-r shadow-lg bg-neutral-100 border-r-neutral-300">
            <aside class="px-4 pt-4 pb-2">
                <h2 class="inline-flex items-center text-xl font-semibold text-purple-500">
                    <BoardlyIcon class="shrink-0" />
                    <span>Boardly</span>
                </h2>
            </aside>
            <nav>
                <ul class="px-4">
                    <li v-for="link in SIDEBAR_LINKS" :key="link.href">
                        <Link :href="route(link.href)"
                            class="flex px-2 py-1.5 text-sm font-medium rounded-lg hover:bg-purple-200 text-neutral-700 hover:text-purple-500">
                            {{ link.name }}
                        </Link>
                    </li>
                </ul>
                <div class="my-2 w-full h-px bg-neutral-300"></div>
                <ul class="px-4">
                    <span class="flex mb-1 text-xs font-medium text-neutral-500">Recientes</span>
                    <li v-for="board in recentBoards" :key="board.id">
                        <Link :href="route('app.boards.show', { board: board.id, slug: board.slug })"
                            class="flex px-2 py-1.5 text-sm font-medium rounded-lg hover:bg-purple-200 text-neutral-700 hover:text-purple-500">
                            {{ board.slug }}
                        </Link>
                    </li>
                    <span v-if="recentBoards.length === 0" class="text-xs text-neutral-500">
                        No hay tableros recientes
                    </span>
                </ul>
            </nav>
        </div>
    </div>
</template>