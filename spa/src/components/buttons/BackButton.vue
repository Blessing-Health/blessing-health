<template>
  <q-btn
    :label="form ? 'Cancel' : 'Go Back'"
    type="button"
    flat
    no-caps
    :to="to"
    @click="!to && !$attrs.onClick && $router.back()"
  />
</template>

<script setup>
defineProps({
  form: Boolean, // Adjusts the button wording slightly if on a form
  to: [String, Object], // Optional route to go back to
});
</script>
