<!-- Produce a row with a side by side label and form controls -->
<template>
  <div class="row items-center q-col-gutter-x-sm">
    <div class="col-12 col-md-3">
      <label>{{ label }}</label>
      <slot name="label-append" />
      <span v-if="required" class="text-negative q-ml-sm">*</span>
    </div>
    <div class="col-12 col-md-9">
      <slot />
    </div>
  </div>
</template>

<script setup>
defineProps({
  label: String,
  required: Boolean, // Adds a required indicator (*)
});
</script>
