<template>
  <q-drawer
    v-model="appStore.sidebarIsOpen"
    show-if-above
    bordered
    side="left"
    :width="280"
  >
    <q-toolbar
      id="sidebar-banner"
      class="flex items-center bg-secondary text-white q-gutter-x-md q-px-md"
    >
      <q-icon name="fa fa-flask" size="sm" />
      <span class="text-h6">{{ appName }}</span>
    </q-toolbar>
    <q-list class="q-mt-md">
      <sidebar-item to="/" title="Dashboard" :icon="entityIcons.dashboard" />
      <sidebar-item to="/mitras" title="Mitras" :icon="entityIcons.dashboard" />

      <q-expansion-item
        :content-inset-level="0.25"
        :icon="entityIcons.users"
        label="Users"
        group="submenu"
      >
        <sidebar-item to="users" title="Users" :icon="entityIcons.users" />
        <sidebar-item to="roles" title="Roles" :icon="entityIcons.users" />
        <sidebar-item
          to="permissions"
          title="Permissions"
          :icon="entityIcons.users"
        />
      </q-expansion-item>
    </q-list>
  </q-drawer>
</template>

<script setup>
import SidebarItem from "./SidebarItem.vue";
import { useAppStore } from "src/stores/appStore";
import { appName } from "src/consts";
import { entityIcons } from "src/utils/icons";
const appStore = useAppStore();
</script>
