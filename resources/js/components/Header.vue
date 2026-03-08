<script setup>
import { useAuth } from '@/composables/useAuth';
import { Link } from '@inertiajs/vue3';

const { isAuthenticated } = useAuth();
</script>

<template>
    <header class="fixed px-4 w-full">
        <div class="flex max-w-7xl justify-between items-center mx-auto min-h-[80px]">
            <div class="text-lg font-bold text-purple-500 font-gantians">BOARDLY</div>
            <nav>
                <ul class="flex gap-5 items-center text-purple-500">
                    <li>
                        <a href="https://github.com/imhvit" target="_blank"
                            class="border-b border-b-transparent hover:border-b-purple-500">GitHub</a>
                    </li>
                    <li v-if="!isAuthenticated">
                        <Link :href="route('register')" class="border-b border-b-transparent hover:border-b-purple-500">
                            Registrarse
                        </Link>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
</template>