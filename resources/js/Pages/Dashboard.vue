<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';



const page = usePage()

const newMessage = ref('');
const messages = ref({});
const user = ref(page.props.auth.user)
const activeUsers = ref({});
const broadcastMessage = () => {
  window.Echo
    .private('chat')
    .whisper('private-message', {
      text: newMessage.value,
      user_id: user.value.id,
      username: user.value.name
    });
};

const listenForMessages = () => {
  window.Echo
    .private('chat')
    .listenForWhisper('private-message', (e) => {
      console.log(e)
      messages.value[e.user_id] = e
    });
};

const listenForPresence = () => {
  window.Echo
    .join('chat')
    .here((users) => {
      users.forEach(user => {
        activeUsers.value[user.id] = user
      })
    })
    .joining((user) => {
      activeUsers.value[user.id] = user
    })
    .leaving((user) => {
      delete activeUsers.value[user.id]
    });
};

onMounted(() => {
  console.log(user.value)
  listenForMessages();
  listenForPresence();
});

onUnmounted(() => {
  window.Echo.leave('chat');
});

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                 <span v-for="user in activeUsers" 
                    :key="user.id" 
                    class="px-3 py-1 bg-green-300 rounded-full text-sm mr-3">
                {{ user.name }}
                </span>
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">


                <div v-for="message in messages" :key="message.user_id" class="relative overflow-hidden bg-white shadow-sm sm:rounded-lg mb-3 dark:bg-gray-800">
                    <div v-if="message.text.length > 0">
                        <span class="absolute top-0 left-0 text-gray-500 text-sm p-2">{{ message.username }}</span>
                    <div class="pt-7 pb-3 px-3 text-gray-900 dark:text-gray-100">
                        {{ message.text }}
                    </div>
                    </div>
                </div>

               <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <input class="w-full" v-model="newMessage" @keyup="broadcastMessage" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
