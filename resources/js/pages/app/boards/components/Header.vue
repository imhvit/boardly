<script setup>
import { router, usePage } from '@inertiajs/vue3'
import { Filter, ArrowDownWideNarrow, Layers, Share2, UserPlus } from 'lucide-vue-next';
import { VIEW_OPTIONS } from '@/consts/headerBoard';
import { computed } from 'vue';

const page = usePage();
const selectedView = computed(() => page.props.view);

const props = defineProps({
    publicId: {
        type: String,
        required: true
    },
    slug: {
        type: String,
        required: true
    },
    description: {
        type: String,
        required: true
    },
    view: {
        type: String,
        required: true
    }
});

const changeView = (view) => {
    router.get(route('app.boards.show', {
        public_id: props.publicId,
        slug: props.slug
    }), {
        view: view
    }, {
        preserveState: true,
        replace: true
    })
};
</script>

<template>
    <header
        class="flex fixed left-0 flex-col space-y-4 w-full top-0 justify-center pl-[266px] h-32 pr-4 bg-neutral-200">
        <div class="flex items-center justify-between gap-4">
            <aside>
                <h1 class="text-xl font-semibold text-purple-500">{{ slug }}</h1>
                <p class="text-sm text-neutral-500">{{ description }}</p>
            </aside>
            <div class="flex items-center gap-4">
                <div>
                    <div
                        class="inline-flex items-center justify-center rounded-full bg-neutral-300 size-8 text-neutral-500">
                        Y
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-purple-500 cursor-pointer rounded-xl hover:bg-purple-600">
                        <UserPlus class="size-4" />
                        <span>Invitar</span>
                    </button>
                    <button
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium border cursor-pointer rounded-xl border-neutral-300 bg-neutral-300/30 hover:bg-neutral-300/60 text-neutral-700">
                        <Share2 class="size-4" />
                        <span>Compartir</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-between gap-4">
            <ul class="flex items-center">
                <li v-for="view in VIEW_OPTIONS" :key="view.query">
                    <button @click="changeView(view.query)"
                        :class="selectedView === view.query ? 'bg-purple-200 text-purple-500' : 'hover:bg-purple-200 hover:text-purple-500'"
                        class="inline-flex items-center gap-2 px-3 py-1 text-sm font-medium rounded-lg cursor-pointer text-neutral-700">
                        <component v-if="view.icon" :is="view.icon" class="size-4" />
                        <span>{{ view.name }}</span>
                    </button>
                </li>
            </ul>
            <ul class="flex items-center">
                <li>
                    <button
                        class="inline-flex items-center gap-2 px-3 py-1 text-sm font-medium rounded-lg cursor-pointer hover:text-purple-500 hover:bg-purple-200 text-neutral-700">
                        <Filter class="size-4" />
                        <span>Filtrar</span>
                    </button>
                </li>
                <li>
                    <button
                        class="inline-flex items-center gap-2 px-3 py-1 text-sm font-medium rounded-lg cursor-pointer hover:text-purple-500 hover:bg-purple-200 text-neutral-700">
                        <Layers class="size-4" />
                        <span>Agrupar por</span>
                    </button>
                </li>
                <li>
                    <button
                        class="inline-flex items-center gap-2 px-3 py-1 text-sm font-medium rounded-lg cursor-pointer hover:text-purple-500 hover:bg-purple-200 text-neutral-700">
                        <ArrowDownWideNarrow class="size-4" />
                        <span>Ordenar por</span>
                    </button>
                </li>
            </ul>
        </div>
    </header>
</template>