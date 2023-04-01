<template>
  <div class="q-gutter-x-xs actions">
    <q-btn
      v-if="!hideEdit"
      label="Edit"
      class="link"
      dense
      unelevated
      no-caps
      :to="edit ? edit(row) : undefined"
      @click="$emit('edit')"
    />
  </div>
</template>

<script setup>
defineProps({
  row: Object,
  hideEdit: Boolean,
  edit: Function,
});

defineEmits(["edit"]);
</script>
