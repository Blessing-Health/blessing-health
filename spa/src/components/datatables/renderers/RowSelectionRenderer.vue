<template>
  <div>
    <form-input v-model="selectionState" type="checkbox" size="xs" />
  </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  row: Object,
  selectionMap: Object,
});

const selectionState = computed({
  get: () => props.selectionMap.has(props.row.id) || false,
  set: (val) => {
    if (val) {
      props.selectionMap.set(props.row.id, props.row);
    } else {
      props.selectionMap.delete(props.row.id);
    }
  },
});
</script>
