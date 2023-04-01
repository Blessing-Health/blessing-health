<template>
  <form-section
    icon="inventory"
    title="Basic Details"
    subtitle="Enter the required info"
  >
    <form-row label="Name" required>
      <form-input type="text" v-model="form.name" placeholder="Create Name" />
    </form-row>
  </form-section>
</template>

<script setup>
defineProps({ form: Object });
</script>
