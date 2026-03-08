<script setup lang="ts">
import Sidebar from '@/components/Sidebar.vue';

</script>

<template>
    <div class="h-screen bg-neutral-200">
        <Sidebar />
        <div class="ml-[250px] h-full p-4">
            <main class="overflow-y-auto h-full">
                <slot />
            </main>
        </div>
    </div>
</template>