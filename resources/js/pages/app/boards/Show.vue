<script setup>
import { useRecentBoards } from '@/composables/useRecentBoards';
import { useDrag } from '@/composables/useDrag';
import AppLayout from '@/layouts/AppLayout.vue';
import { onMounted } from 'vue';
import Header from './components/Header.vue';
import CardContainer from './components/CardContainer.vue';
import { Head } from '@inertiajs/vue3';

defineOptions({ layout: AppLayout });

const props = defineProps({
    board: Object,
    view: String
});

const initialData = [
    {
        id: '01ht68m9x2a...', // Recomendación: Usa UUIDv4 o ULID para IDs públicos
        board_id: '01ht68m...',
        title: 'To Do',
        order: 1000, // Carga posicional (Explicado abajo)
        tasks: [
            {
                id: '01ht68k3p...',
                column_id: '01ht68m9x2a...',
                title: 'Diseñar esquema de base de datos',
                description: 'Crear migraciones para Boards, Columns y Tasks.',
                order: 1000,
                date: '15 abr', // Formateado desde el backend (created_at o due_date)
                labels: [
                    { id: 1, name: 'Arquitectura', color: 'purple' },
                    { id: 2, name: 'Backend', color: 'blue' }
                ],
                assigned_to: {
                    id: 99,
                    name: 'John Doe',
                    avatar: 'https://ui-avatars.com/api/?name=John+Doe'
                }
            },
            {
                id: '01ht68k5w...',
                column_id: '01ht68m9x2a...',
                title: 'Configurar CI/CD con GitHub Actions',
                description: 'Pipeline para pruebas de Vue y Laravel.',
                order: 2000,
                date: '16 abr',
                labels: [
                    { id: 3, name: 'DevOps', color: 'green' }
                ],
                assigned_to: null
            }
        ]
    },
    {
        id: '01ht68p1z...',
        board_id: '01ht68m...',
        title: 'In Progress',
        order: 2000,
        tasks: [
            {
                id: '01ht68q9m...',
                column_id: '01ht68p1z...',
                title: 'Integrar API Drag & Drop HTML5',
                description: 'Refactorizar composable useKanban para soportar columnas.',
                order: 1000,
                date: 'Hoy',
                labels: [
                    { id: 4, name: 'Frontend', color: 'yellow' }
                ],
                assigned_to: {
                    id: 42,
                    name: 'Jane Smith',
                    avatar: 'https://ui-avatars.com/api/?name=Jane+Smith'
                }
            }
        ]
    },
    {
        id: '01ht68r4x...',
        board_id: '01ht68m...',
        title: 'Done',
        order: 3000,
        tasks: []
    }
];

const { addRecentBoard } = useRecentBoards();
const { columns, placeholder, onDragStart, onTaskDragOver, onColumnDragOver, onDrop, resetDrag } = useDrag(initialData);

onMounted(() => {
    addRecentBoard({ id: props.board.public_id, slug: props.board.title });
});
</script>

<template>

    <Head :title="board.title" />
    <Header :board-id="board.public_id" :title="board.title" :description="board.description" :view="view" />

    <div class="flex overflow-x-auto gap-2 px-4 pb-2 h-full pt-34" @dragover.prevent @drop="onDrop"
        @dragend="resetDrag">
        <template v-for="(column, index) in columns" :key="column.id">
            <div v-if="placeholder.type === 'column' && placeholder.index === index"
                :style="{ width: placeholder.width + 'px' }"
                class="h-10 bg-purple-200 rounded-xl border border-purple-400 border-dashed transition-all shrink-0">
            </div>
            <CardContainer :column="column" :placeholder="placeholder" @start-drag="onDragStart" @drag-end="resetDrag"
                @task-hover="onTaskDragOver" @col-hover="onColumnDragOver" @drop-item="onDrop" />
        </template>

        <div v-if="placeholder.type === 'column' && placeholder.index === columns.length"
            :style="{ width: placeholder.width + 'px' }"
            class="h-10 bg-purple-200 rounded-xl border border-purple-400 border-dashed transition-all shrink-0">
        </div>

    </div>
</template>