<script setup>
import { ref } from "vue";

import { Link } from "@inertiajs/vue3";

import Drawer from "primevue/drawer";

const visibleRight = ref(false);
</script>

<template>
  <div class="h-dvh bg-gray-100 dark:bg-gray-900 w-full relative">
    <Button outlined icon="pi pi-bars" @click="visibleRight = true" class="!absolute top-2 right-2" />
    <Drawer
      v-model:visible="visibleRight"
      header="Right Drawer"
      position="right"
    >
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
        veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
        commodo consequat.
      </p>
    </Drawer>
    <slot />
  </div>
</template>
