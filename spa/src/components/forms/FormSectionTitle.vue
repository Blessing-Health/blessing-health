<template>
  <q-item>
    <q-item-section avatar>
      <q-avatar color="primary" text-color="white" :icon="icon" />
    </q-item-section>

    <q-item-section>
      <q-item-label class="text-h4 text-weight-medium text-primary">
        {{ title }}
      </q-item-label>

      <q-item-label v-if="subtitle" class="text-subtitle">
        {{ subtitle }}
      </q-item-label>
    </q-item-section>

    <q-item-section v-if="$slots.default" side>
      <slot />
    </q-item-section>
  </q-item>
</template>

<script setup>
defineProps({
  icon: String,
  title: String,
  subtitle: String,
});
</script>
