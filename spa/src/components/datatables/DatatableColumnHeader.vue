<template>
  <th
    :align="col.align"
    :class="classes"
    class="text-no-wrap"
    @click="applySort"
  >
    {{ col.label }}
    <q-icon
      v-if="col.sortable"
      :color="columnIsSorted ? 'primary' : undefined"
      :name="pagination.descending ? 'expand_less' : 'expand_more'"
    />
  </th>
</template>
<script setup>
import { computed } from "vue";
const props = defineProps({
  col: Object,
  pagination: Object,
});

const emit = defineEmits(["reload"]); //tell the datatable to reload

const columnIsSorted = computed(
  () => props.pagination.sort_by == props.col.field
);

const classes = {
  ...props.col.classes.reduce((out, cls) => {
    out[cls] = true;
    return out;
  }, {}),
};

const applySort = () => {
  if (!props.col.sortable) return;

  // Column already sorted? Flip descending prop
  if (columnIsSorted.value) {
    props.pagination.descending = !props.pagination.descending;
    triggerReload(false);
  } else {
    props.pagination.sort_by = props.col.field;
    props.pagination.descending = false;
    triggerReload(true);
  }
};
const triggerReload = (resetPaging) => {
  if (resetPaging) props.pagination.page = 1;
  emit("reload");
};
</script>
