<script setup>
import Layout from '@/Layout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';

const page = usePage()
const user = ref(page.props.auth.user)
const myRooms = ref(page.props.myRooms)
const suscribedRooms = ref(page.props.suscribedRooms)


onMounted(() => {

});

onUnmounted(() => {

});

</script>

<template>
    <Head title="Dashboard" />

    <Layout>
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

                <h2 class="text-2xl font-bold mb-4">Мои комнаты</h2>

               <div v-for="room in myRooms" :key="room.id" class="mb-2 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-bold"><Link :href="route('chat', room.hash)">{{ room.name }}</Link></h3>


                    </div>
                </div>

                <h2 class="text-2xl font-bold my-4">Подписки</h2>

                <div v-for="room in suscribedRooms" :key="room.id" class="mb-2 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-bold"><Link :href="route('chat', room.hash)">{{ room.name }}</Link></h3>

                    </div>
                </div>

                <h3 class="text-lg font-bold my-4"><Link :href="route('room.new')">Создать новую комнату</Link></h3>
            </div>
        </div>
    </Layout>
</template>
