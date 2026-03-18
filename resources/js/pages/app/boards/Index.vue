<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import { ref, Transition } from 'vue';
import OptionBox from '@/components/OptionBox.vue';
import { Plus, Users, Calendar, CheckCircle } from 'lucide-vue-next';

const openBox = ref(false);
const boardTitle = ref('');
const error = ref('');
const loading = ref(false);

defineOptions({ layout: AppLayout });

defineProps({
    boards: {
        type: Array,
        required: true
    },
});

const newBoard = () => {
    if (!boardTitle.value.trim()) {
        error.value = 'Nombre requerido';
        return;
    }
    error.value = '';
    loading.value = true;
    router.post(route('app.boards.store'), {
        title: boardTitle.value
    }, {
        onFinish: () => {
            loading.value = false;
            boardTitle.value = '';
        },
        onError: (errors) => {
            error.value = errors.title;
            loading.value = false;
        }
    });
}
</script>

<template>
    <div class="flex items-center justify-between max-w-4xl pt-4 mx-auto">
        <h1 class="text-xl font-semibold text-purple-500">Mis tableros</h1>
        <div class="relative">
            <button @click="() => { openBox = !openBox; error = '' }"
                class="inline-flex gap-2 items-center px-2 py-1.5 text-sm text-white bg-purple-500 rounded-xl cursor-pointer font-lg">
                <Plus class="size-4" />
                <span>Nuevo</span>
            </button>
            <Transition name="option-box">
                <OptionBox v-if="openBox">
                    <div class="flex flex-col gap-y-1">
                        <input required v-model="boardTitle" type="text" placeholder="Nombre del tablero"
                            class="w-full px-2 py-1 text-sm border rounded-lg outline-none text-neutral-500 border-neutral-300 placeholder:text-neutral-400 bg-neutral-200" />
                        <span v-if="error" class="text-xs text-red-500">{{ error }}</span>
                    </div>
                    <button @click="newBoard" :disabled="loading"
                        class="w-full px-2 py-1 text-sm font-medium text-white bg-purple-500 rounded-lg cursor-pointer disabled:cursor-not-allowed disabled:opacity-50">
                        <span v-if="loading">Creando...</span>
                        <span v-else>Crear</span>
                    </button>
                </OptionBox>
            </Transition>
        </div>
    </div>
    <section class="max-w-4xl mx-auto my-4 select-none">
        <ul class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-4">
            <li v-for="board in boards" :key="board.id">
                <Link :href="route('app.boards.show', { public_id: board.public_id, slug: board.title })">
                    <article class="py-3 space-y-2 border rounded-2xl bg-neutral-100 border-neutral-300">
                        <div class="px-3 space-y-2">
                            <h3 class="text-sm font-semibold select-text text-neutral-700 line-clamp-1">{{ board.title
                                }}</h3>
                            <p class="text-sm text-neutral-500 line-clamp-2">
                                {{ board.description }}
                            </p>
                        </div>
                        <div :class="['flex items-center px-3', board.tag ? ' justify-between' : ' justify-end']">
                            <span v-if="board.tag"
                                class="px-1.5 py-0.5 text-xs text-purple-500 bg-purple-200 rounded-sm">
                                {{ board.tag }}
                            </span>
                            <div
                                class="inline-flex items-center justify-center text-xs rounded-full size-5 bg-neutral-300 border-neutral-400 text-neutral-500">
                                Y
                            </div>
                        </div>
                        <div class="flex w-full h-px mt-2 bg-neutral-200"></div>
                        <div class="flex items-center justify-between gap-2 px-3">
                            <div class="flex items-center gap-2 text-neutral-500">
                                <div class="relative flex items-center gap-1 group">
                                    <CheckCircle class="size-4" />
                                    <span class="text-xs">?</span>
                                    <span
                                        class="absolute top-full left-1/2 px-1.5 py-1 mt-1 text-xs rounded-lg border shadow opacity-0 transition-opacity duration-200 -translate-x-1/2 pointer-events-none group-hover:opacity-100 border-neutral-200 bg-neutral-100">
                                        Tareas
                                    </span>
                                </div>
                                <div class="relative flex items-center gap-1 group">
                                    <Users class="size-4" />
                                    <span class="text-xs">{{ board.users_count }}</span>
                                    <span
                                        class="absolute top-full left-1/2 px-1.5 py-1 mt-1 text-xs rounded-lg border shadow opacity-0 transition-opacity duration-200 -translate-x-1/2 pointer-events-none group-hover:opacity-100 border-neutral-200 bg-neutral-100">
                                        Miembros
                                    </span>
                                </div>

                            </div>
                            <div class="relative flex items-center gap-1 text-neutral-500 group">
                                <Calendar class="size-4" />
                                <span class="text-xs">
                                    {{
                                        new Date(board.created_at).toLocaleDateString('es-ES', {
                                            day: '2-digit',
                                            month: 'short',
                                        })
                                    }}
                                </span>
                                <span
                                    class="absolute top-full left-1/2 px-1.5 py-1 mt-1 w-max text-xs rounded-lg border shadow opacity-0 transition-opacity duration-200 -translate-x-1/2 pointer-events-none group-hover:opacity-100 border-neutral-200 bg-neutral-100">
                                    {{
                                        new Date(board.created_at).toLocaleDateString('es-ES', {
                                            day: '2-digit',
                                            month: 'long',
                                            year: '2-digit',
                                        }) + ' - ' +
                                        new Date(board.created_at).toLocaleTimeString('en-ES', {
                                            hour: '2-digit',
                                            minute: '2-digit',
                                        })
                                    }}
                                </span>
                            </div>
                        </div>
                    </article>
                </Link>
            </li>
        </ul>
    </section>
</template>

<style scoped>
.option-box-enter-active,
.option-box-leave-active {
    transition: all 0.2s ease;
}

.option-box-enter-from,
.option-box-leave-to {
    opacity: 0;
    transform: translateY(-5px);
}

.option-box-enter-to,
.option-box-leave-from {
    opacity: 1;
    transform: translateY(0);
}
</style>