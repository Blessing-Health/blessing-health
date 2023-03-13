<template>
  <q-item clickable exact>
    <q-item-section v-if="icon" avatar>
      <q-icon :name="icon" />
    </q-item-section>
    <q-item-section>
      <q-item-label>
        {{ title }}
      </q-item-label>
    </q-item-section>
  </q-item>
</template>

<script setup>
defineProps({
  title: String,
  icon: String,
});
</script>
