<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';

const page = usePage()
const user = ref(page.props.auth.user)


onMounted(() => {

});

onUnmounted(() => {

});

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                 <span class="px-3 py-1 bg-green-300 rounded-full text-sm mr-3">
                {{ user.name }}
                </span>
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">


               <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        Главная страница
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
