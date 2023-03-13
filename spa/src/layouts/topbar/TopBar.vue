<template>
  <q-header elevated>
    <q-toolbar>
      <q-btn flat dense round icon="menu" @click="appStore.toggleSidebar" />

      <q-toolbar-title> </q-toolbar-title>

      <active-user-dropdown />
    </q-toolbar>
  </q-header>
</template>

<script setup>
import { useAppStore } from "../../stores/appStore";
import ActiveUserDropdown from "./ActiveUserDropdown.vue";

const appStore = useAppStore();
</script>
