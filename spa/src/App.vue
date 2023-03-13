<template>
  <router-view v-if="authStore.user" />
</template>

<script setup>
import { useAuthStore } from "./stores/authStore";
const authStore = useAuthStore();
</script>
