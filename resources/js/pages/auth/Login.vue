<script setup>
import BoardlyIcon from '@/icons/svg/BoardlyIcon.vue';
import PersonAuthentication from '@/icons/svg/PersonAuthentication.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { Eye } from 'lucide-vue-next';
import { EyeClosed } from 'lucide-vue-next';
import { ref } from 'vue';

const togglePassword = ref(false);
const isAnimating = ref(true)

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
}
</script>

<template>
    <main class="grid overflow-hidden grid-cols-1 h-screen bg-purple-100 xl:grid-cols-2">
        <div class="grid place-items-center p-4">
            <div class="flex flex-col py-20 w-full max-w-xl h-full">
                <div class="mb-10 animate-show-content" style="animation-delay: .2s;">
                    <h2 class="inline-flex items-center text-lg font-semibold text-purple-500">
                        <BoardlyIcon class="shrink-0" />
                        <span>Boardly</span>
                    </h2>
                </div>
                <form :class="['form-transition', { 'pointer-events-none': isAnimating }]" @submit.prevent="submit">
                    <header class="mb-10 space-y-4 animate-show-content" style="animation-delay: .4s;">
                        <h1 class="text-5xl font-bold text-purple-950">Hola,<br />Bienvenido de nuevo</h1>
                        <p class="text-purple-800/80">Bienvenido de regreso, ingresa tus credenciales para continuar</p>
                    </header>
                    <div class="space-y-4 animate-show-content" style="animation-delay: .6s;">
                        <div class="flex flex-col space-y-1">
                            <label for="email" class="text-sm font-medium text-purple-950">Correo electrónico</label>
                            <input required v-model="form.email" type="email" id="email" name="email" autofocus
                                autocomplete="email" placeholder="email@example.com"
                                class="p-2 w-full max-w-xs text-sm text-purple-500 rounded-lg border outline-none border-purple-500/60 placeholder:text-purple-500/60 focus:bg-purple-500/5 focus:border-purple-500" />
                            <span v-if="form.errors.email" class="text-xs text-red-500">
                                {{ form.errors.email }}
                            </span>
                        </div>
                        <div class="flex flex-col space-y-1">
                            <label for="password" class="text-sm font-medium text-purple-950">Contraseña</label>
                            <div
                                class="relative p-2 pr-10 max-w-xs text-sm text-purple-500 rounded-lg border border-purple-500/60 focus-within:border-purple-500 focus-within:bg-purple-500/5">
                                <input required v-model="form.password" :type="togglePassword ? 'text' : 'password'"
                                    id="password" name="password" autocomplete="new-password" placeholder="********"
                                    class="w-full outline-none placeholder:text-purple-500/60" />
                                <button type="button"
                                    class="absolute right-2 top-1/2 p-1 rounded-md -translate-y-1/2 hover:bg-purple-500/10"
                                    @click="togglePassword = !togglePassword">
                                    <EyeClosed v-if="!togglePassword" class="size-4" />
                                    <Eye v-else class="size-4" />
                                </button>
                            </div>
                            <span v-if="form.errors.password" class="text-xs text-red-500">
                                {{ form.errors.password }}
                            </span>
                        </div>
                        <div>
                            <label class="flex gap-2 items-center">
                                <input v-model="form.remember" type="checkbox" name="remember" />
                                <span class="text-sm text-purple-950">Recordarme</span>
                            </label>
                        </div>
                    </div>
                    <button type="submit"
                        class="px-4 py-2 mt-6 text-sm font-medium text-white bg-purple-500 rounded-lg animate-show-content"
                        style="animation-delay: .8s;">
                        Iniciar sesión
                    </button>
                    <footer class="mt-6 text-sm text-purple-800/80 animate-show-content" style="animation-delay: 1s;"
                        @animationend.once="isAnimating = false">
                        <p>¿No tienes una cuenta?
                            <Link :href="route('register')"
                                class="font-medium border-b text-purple-950 hover:border-purple-950 border-b-transparent">
                                Regístrate
                            </Link>
                        </p>
                    </footer>
                </form>
            </div>
        </div>
        <div class="hidden overflow-hidden p-4 xl:block">
            <div
                class="grid overflow-hidden place-items-center h-full rounded-2xl bg-purple-950 animate-opacity-content">
                <PersonAuthentication class="text-purple-900" />
            </div>
        </div>
    </main>
</template>

<style scoped>
.animate-show-content {
    animation: show-content .3s ease-out;
    animation-fill-mode: both;

}

.animate-opacity-content {
    animation: opacity-content 1s ease-out;
    animation-fill-mode: both;
}

@keyframes show-content {
    from {
        transform: translateX(-100px);
        opacity: 0;
    }

    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes opacity-content {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}
</style>