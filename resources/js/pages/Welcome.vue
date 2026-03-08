<script setup>
import Header from '@/components/Header.vue';
import { useAuth } from '@/composables/useAuth';
import { Link } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';

const { isAuthenticated } = useAuth();
</script>

<template>
    <Header />
    <main class="px-4 pt-20 h-screen bg-purple-100">
        <section class="py-40 mx-auto space-y-6 max-w-6xl">
            <h1 class="text-purple-500 text-5xl md:text-6xl lg:text-7xl md:max-w-[80%] font-gantians">
                Organiza, prioriza y completa tus tareas con Boardly
            </h1>
            <p class="md:max-w-[80%] text-lg md:text-xl lg:text-2xl font-mono text-purple-500/80">
                La herramienta que te ayudará a organizar tus tareas diarias, priorizarlas y completarlas de
                manera eficiente.
            </p>
            <Link :href="isAuthenticated ? route('app.index') : route('login')"
                class="inline-flex gap-2 items-center px-4 py-2 font-mono text-white bg-purple-500">
                <template v-if="isAuthenticated">
                    Continuar a la app
                </template>
                <template v-else>
                    <Plus />
                    Iniciar sesión
                </template>
            </Link>
        </section>
    </main>
</template>