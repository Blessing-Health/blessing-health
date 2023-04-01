<template>
  <datatable v-bind="tableProps">
    <template #column-name="{ value }">
      {{ value }}
    </template>
    <template #column-actions="{ row }">
      <action-renderer
        :row="row"
        :edit="(row) => ({ name: 'edit-roles', params: { id: row.id } })"
      />
    </template>
  </datatable>
</template>

<script setup>
import Datatable from "src/components/datatables/Datatable.vue";
import ActionRenderer from "src/components/datatables/renderers/ActionRenderer.vue";

import {
  column,
  actionsColumn,
} from "src/components/datatables/datatableColumnBuilder.js";
const tableProps = {
  url: "roles",
  paginationDefaults: {
    sort_by: "updated_at",
    descending: true,
  },
  columns: [column("name"), actionsColumn()],
};
</script>
