<script setup>
import Sidebar from '@/components/Sidebar.vue';

</script>

<template>
    <div class="min-h-screen bg-neutral-200">
        <Sidebar />
        <div class="ml-[250px] h-screen">
            <main class="h-full">
                <slot />
            </main>
        </div>
    </div>
</template>