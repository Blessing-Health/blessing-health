<template>
  <transition
    appear
    name="slide-fade"
    mode="out-in"
    :class="vertical ? 'vertical' : 'horizontal'"
    :style="{ transitionDelay: `${delay}ms` }"
  >
    <slot />
  </transition>
</template>

<script setup>
defineProps({
  vertical: Boolean, //slide up down instead of left/right
  delay: {
    type: Number,
    default: 0,
  },
});
</script>

<style>
.slide-fade-enter-active .slide-fade-leave-active {
  transition: all 100ms;
}
.horizontal.slide-fade-enter-from,
.horizontal.slide-fade-enter-leave-to {
  transform: translateX(20px);
  opacity: 0;
}
.vertical.slide-fade-enter-from,
.vertical.slide-fade-enter-leave-to {
  transform: translateY(20px);
  opacity: 0;
}
</style>
