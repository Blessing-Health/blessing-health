<template>
  <page-wrapper>
    <mitras-datatable />
    <template #page-actions>
      <add-button fab :to="{ name: 'create_user' }" />
    </template>
  </page-wrapper>
</template>

<script setup>
import { useAppStore } from "src/stores/appStore";
import { entityIcons } from "src/utils/icons";
import MitrasDatatable from "./MitrasDatatable.vue";

const appStore = useAppStore();

appStore.setPageInfo({
  title: "Mitras",
  section: "Mitra Management",
  subtitle: "Showing the mitras lists",
  icon: entityIcons.users,
});
</script>
