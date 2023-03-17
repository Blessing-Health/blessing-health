<template>
  <div class="q-table__bottom row items-center justify-between q-gutter-x-md">
    <div class="row">
      <slot />
    </div>
    <div class="row q-gutter-x-md">
      <div class="q-table__control">
        <span class="q-table__bottom-item">Records per page:</span>

        <q-select
          v-model="pagination.take"
          :options="pageLengths"
          borderless
          dense
          @update:model-value="triggerReload(true)"
        />
      </div>
      <div class="q-table__control">
        <span class="q-table__bottom-item gt-sm">
          Showing {{ pageStart }} to {{ pageEnd }} of
          {{ number(totalRows) }} rows
        </span>

        <q-pagination
          v-model="pagination.page"
          :max="Math.ceil(totalRows / pagination.take)"
          :max-pages="maxPages"
          direction-links
          boundary-links
          @update:model-value="triggerReload(false)"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { number } from "src/utils/formats.js";
import { computed } from "vue";

const props = defineProps({
  pagination: Object,
  totalRows: Number,
  maxPages: {
    type: Number,
    default: 6,
  },
});

const emit = defineEmits(["reload"]); // Tell the datatable to reload its data

const pageLengths = [15, 50, 100, 200];
const pageStart = computed(
  () =>
    1 + props.pagination.page * props.pagination.take - props.pagination.take
);
const pageEnd = computed(() =>
  Math.min(props.totalRows, pageStart.value - 1 + props.pagination.take)
);

const triggerReload = (resetPaging) => {
  if (resetPaging) props.pagination.page = 1;
  emit("reload");
};
</script>
