<template>
  <page-wrapper>
    <users-datatable />
    <template #page-actions>
      <add-button fab :to="{ name: 'create_user' }" />
    </template>
  </page-wrapper>
</template>

<script setup>
import { useAppStore } from "src/stores/appStore";
import { entityIcons } from "src/utils/icons";
import UsersDatatable from "./UsersDatatable.vue";

const appStore = useAppStore();

appStore.setPageInfo({
  title: "Users",
  section: "User Management",
  subtitle: "Showing the user lists",
  icon: entityIcons.users,
});
</script>
