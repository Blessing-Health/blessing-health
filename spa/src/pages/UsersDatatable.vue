<template>
  <datatable v-bind="tableProps" no-auto-focus class="q-mb-md">
    sasas
    <template #column-name="{ value }">
      {{ value }}
    </template>
  </datatable>
</template>

<script setup>
import Datatable from "components/datatables/Datatable.vue";
import {
  column,
  actionsColumn,
} from "src/components/datatables/datatableColumnBuilder.js";
const tableProps = {
  url: "users",
  paginationDefaults: {
    sort_by: "updated_at",
    descending: true,
  },
  columns: [
    column("name"),
    column("email"),
    column("roles").setUnsortable(),
    actionsColumn(),
  ],
};
</script>
