<template>
  <div class="flex items-center text-grey-5 q-py-lg q-px-md">
    <q-icon :name="icon" size="md" class="on-left" />
    <div>
      <div class="text-h5">
        {{ title || "Nothing to show" }}
      </div>
      <slot />
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: String,

  icon: {
    type: String,
    default: "auto_awesome",
  },
});
</script>
