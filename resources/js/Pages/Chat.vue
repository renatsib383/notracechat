<script setup>
import ChatLayout from "@/Layouts/ChatLayout.vue";
import { Head, usePage } from "@inertiajs/vue3";
import { ref, onMounted, onUnmounted } from "vue";

const page = usePage();

const newMessage = ref("");
const messages = ref({});
const user = ref(page.props.auth.user);
const room_hash = ref(page.props.room_hash);
const activeUsers = ref({});
const editableDiv = ref(null);
const broadcastTyping = () => {
  window.Echo.private("chat." + room_hash.value).whisper("private-message", {
    text: newMessage.value,
    user_id: user.value.id,
    username: user.value.name,
  });
};

const handleInput = () => {
  newMessage.value = editableDiv.value.innerText;
  broadcastTyping();
};

const clearText = () => {
  editableDiv.value.innerHTML = "";
  editableDiv.value.focus(); // Возвращаем фокус
  newMessage.value = ""; // Также очищаем значение в ref
  broadcastTyping();
};

const listenForMessages = () => {
  window.Echo.private("chat." + room_hash.value).listenForWhisper(
    "private-message",
    (e) => {
      console.log(e);
      messages.value[e.user_id] = e;
    }
  );
};

const listenForPresence = () => {
  window.Echo.join("chat." + room_hash.value)
    .here((users) => {
      users.forEach((user) => {
        activeUsers.value[user.id] = user;
      });
    })
    .joining((user) => {
      activeUsers.value[user.id] = user;
    })
    .leaving((user) => {
      delete activeUsers.value[user.id];
    });
};

onMounted(() => {
  console.log(user.value);
  listenForMessages();
  listenForPresence();
});

onUnmounted(() => {
  window.Echo.leave("chat." + room_hash.value);
});
</script>

<template>
  <Head title="Dashboard" />

  <div class="bg-blue-100 h-dvh relative">
    <div class="absolute top-0 left-0 w-full bg-red-100 py-1">
      <span
        v-for="user in activeUsers"
        :key="user.id"
        class="px-3 py-1 bg-green-300 rounded-full text-sm mr-1"
      >
        {{ user.name }}
      </span>
    </div>

    <div class="absolute bottom-0 left-0 w-full">
      <div
        v-for="message in messages"
        :key="message.user_id"
        class="relative overflow-hidden bg-white shadow-sm rounded-lg m-3"
      >
        <div v-if="message.text.trim() !== ''">
          <span class="absolute top-0 left-0 text-gray-500 text-sm p-2">{{
            message.username
          }}</span>
          <div
            v-html="message.text.replace(/\n/g, '<br>')"
            class="pt-7 pb-3 px-3 text-gray-900 dark:text-gray-100"
          ></div>
        </div>
      </div>

      <div class="relative">
        <div
          ref="editableDiv"
          contenteditable="true"
          @input="handleInput"
          class="border border-gray-300 bg-white p-2 min-h-[40px] outline-none"
          placeholder="Введите текст..."
        ></div>
        <div
          v-if="newMessage.length > 0"
          @click="clearText"
          class="absolute bottom-0 right-0 p-2 text-red-500 cursor-pointer bg-gray-200"
        >
          {{ newMessage.length }}
        </div>
      </div>
    </div>
  </div>
</template>
