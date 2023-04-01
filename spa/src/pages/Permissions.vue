<template>
  <page-wrapper>
    <permissions-datatable />
    <template #page-actions>
      <add-button fab :to="{ name: 'create_permissions' }" />
    </template>
  </page-wrapper>
</template>

<script setup>
import PermissionsDatatable from "./PermissionsDatatable.vue";
import { useAppStore } from "src/stores/appStore";
import { entityIcons } from "src/utils/icons";
const appStore = useAppStore();

appStore.setPageInfo({
  title: "Permission",
  section: "Permissions Management",
  subtitle: "Showing the master permissions",
  icon: entityIcons.user,
  officeId: "auto",
});
</script>
