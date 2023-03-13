import { useAuthStore } from 'src/stores/authStore';

<template>
  <q-btn-dropdown
    stretch
    flat
    :label="authStore.user.first_name"
    no-caps
    icon="account_circle"
  >
    <q-list>
      <q-item to="profile" clickable>
        <q-item-section>My Profile</q-item-section>
      </q-item>
      <q-item clickable @click="authStore.logout()">
        <q-item-section> Logout </q-item-section>
      </q-item>
    </q-list>
  </q-btn-dropdown>
</template>

<script setup>
import { useAuthStore } from "../../stores/authStore";
const authStore = useAuthStore();
</script>
