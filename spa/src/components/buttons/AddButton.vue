<template>
  <q-btn
    :color="secondary ? 'info' : 'primary'"
    icon="add"
    :label="what ? `New ${what}` : undefined"
    no-caps
  />
</template>

<script setup>
defineProps({
  secondary: Boolean,
  what: String,
});
</script>
