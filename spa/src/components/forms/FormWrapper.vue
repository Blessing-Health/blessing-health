<template>
  <q-card flat square class="form-section" :class="{ 'q-pa-lg': !dense }">
    <form-section-title v-if="title" v-bind="$props" />
    <q-card-section v-if="shown" :class="{ 'q-gutter-y-sm': !dense }">
      <slot />
    </q-card-section>
    <q-btn
      v-else
      unelevated
      no-caps
      icon="keyboard_arrow_down"
      label="Click to show"
      @click="shown = true"
    />
  </q-card>
</template>

<script setup>
import { ref } from "vue";

const props = defineProps({
  icon: String,
  title: String,
  subtitle: String,
  dense: Boolean,
  collapsed: Boolean, // Initially collapse this form section until the user clicks to reveal it (useful for hiding unimportant fields)
});

const shown = ref(!props.collapsed);
</script>

<style lang="scss">
// Remove extra horizontal padding on small screens
@media (max-width: $breakpoint-sm) {
  .form-section {
    padding-left: 0;
    padding-right: 0;
  }
}
</style>
