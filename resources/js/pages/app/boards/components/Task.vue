<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Clock } from 'lucide-vue-next';

</script>

<template>
    <Link href="#" v-for="i in 5" :key="i"
        class="overflow-hidden p-2 space-y-1 text-sm rounded-md outline-none focus-visible:inset-ring-2 focus-visible:inset-ring-purple-500 shrink-0 bg-neutral-200">
        <div class="flex flex-wrap gap-1">
            <span class="px-1.5 text-xs font-medium text-purple-500 bg-purple-200 rounded-sm">Etiqueta</span>
            <span class="px-1.5 text-xs font-medium text-blue-500 bg-blue-200 rounded-sm">Etiqueta</span>
            <!-- <span class="px-1.5 text-xs font-medium text-green-500 bg-green-200 rounded-sm">Etiqueta</span>
                <span class="px-1.5 text-xs font-medium text-yellow-500 bg-yellow-200 rounded-sm">Etiqueta</span>
                <span class="px-1.5 text-xs font-medium text-orange-500 bg-orange-200 rounded-sm">Etiqueta</span> -->
        </div>
        <p class="text-neutral-700">Crear un componente para todas las paginas de la aplicación que sean
            mobile-first {{ i }}
        </p>
        <div>
            <div class="inline-flex gap-1 items-center text-neutral-500">
                <Clock class="size-4" />
                <span class="text-xs font-medium">27 mar</span>
            </div>
        </div>
    </Link>
</template>