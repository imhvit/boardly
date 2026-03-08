<script setup>
defineOptions({
    inheritAttrs: false,
});

defineProps({
    className: String,
})
</script>
<template>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 16 16" :class="className" v-bind="$attrs"><g fill="none"><path fill="url(#grad1)" d="m14 10-3-1-3 1-1 2 1 2h3.5a2.5 2.5 0 0 0 2.5-2.5z"/><path fill="url(#grad2)" d="M8 2 7 6l1 4h6V4.5A2.5 2.5 0 0 0 11.5 2z"/><path fill="url(#grad3)" d="M8 14V6L5 5 2 6v5.5A2.5 2.5 0 0 0 4.5 14z"/><path fill="url(#grad4)" d="M8 2v4H2V4.5A2.5 2.5 0 0 1 4.5 2z"/><defs><linearGradient id="grad1" x1="4.667" x2="8.327" y1="7.182" y2="15.777" gradientUnits="userSpaceOnUse"><stop stop-color="#c084fc"/><stop offset="1" stop-color="#9333ea"/></linearGradient><linearGradient id="grad2" x1="8.4" x2="13.077" y1="2.889" y2="9.103" gradientUnits="userSpaceOnUse"><stop stop-color="#a855f7"/><stop offset="1" stop-color="#7e22ce"/></linearGradient><linearGradient id="grad3" x1="2.857" x2="8.01" y1="6.421" y2="11.174" gradientUnits="userSpaceOnUse"><stop stop-color="#9333ea"/><stop offset="1" stop-color="#6b21a8"/></linearGradient><linearGradient id="grad4" x1="2.857" x2="4.433" y1="2.8" y2="6.881" gradientUnits="userSpaceOnUse"><stop stop-color="#c084fc"/><stop offset="1" stop-color="#a855f7"/></linearGradient></defs></g></svg>
</template>