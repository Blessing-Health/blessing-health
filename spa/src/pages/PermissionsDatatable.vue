<template>
  <datatable v-bind="tableProps">
    <template #column-name="{ value }">
      {{ value }}
    </template>
  </datatable>
</template>

<script setup>
import Datatable from "src/components/datatables/Datatable.vue";
import {
  column,
  actionsColumn,
} from "src/components/datatables/datatableColumnBuilder.js";
const tableProps = {
  url: "permissions",
  paginationDefaults: {
    sort_by: "updated_at",
    descending: true,
  },
  columns: [column("name"), column("permission"), actionsColumn()],
};
</script>
