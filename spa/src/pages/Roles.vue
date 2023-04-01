<template>
  <page-wrapper>
    <roles-datatable />
    <template #page-actions>
      <add-button fab :to="{ name: 'create_roles' }" />
    </template>
  </page-wrapper>
</template>

<script setup>
import { useAppStore } from "src/stores/appStore";
import { entityIcons } from "src/utils/icons";
import RolesDatatable from "./RolesDatatable.vue";
const appStore = useAppStore();

appStore.setPageInfo({
  title: "Role",
  section: "Roles Management",
  subtitle: "Showing the master roles",
  icon: entityIcons.priceLists,
  officeId: "auto",
});
</script>
