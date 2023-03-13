<template>
  <q-page>
    <slide-transition vertical>
      <slot />
    </slide-transition>
  </q-page>
</template>

<script setup>
import SlideTransition from "../../components/interactions/SlideTransition.vue";
</script>
