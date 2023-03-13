<template>
  <transition :name="transitionName" :mode="transitionMode">
    <slot />
  </transition>
</template>

<script setup>
import { onBeforeMount, ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

const transitionName = ref("slide");
const transitionMode = ref("out-in");

onBeforeMount(() => {
  // Determine whether we are sliding back or forwards depending on number of segments in target route url
  router.beforeEach((to, from, next) => {
    const toDepth = to.path == "/" ? 0 : to.path.split("/").length;
    const fromDepth = from.path == "/" ? 0 : from.path.split("/").length;
    transitionName.value = toDepth >= fromDepth ? "slide-left" : "slide-right";
    next();
  });
});
</script>

<style lang="scss">
/**
* Transition classes to be used with vue transition component for a slide in-out effect
*/
.slide-left-enter-active,
.slide-left-leave-active,
.slide-right-enter-active,
.slide-right-leave-active {
  transition-duration: 0.1s;
  transition-property: opacity, transform;
  transition-timing-function: cubic-bezier(0.55, 0, 0.1, 1);
  overflow: hidden;
}

.slide-left-enter,
.slide-right-leave-active {
  opacity: 0;
  transform: translate(2em, 0);
}

.slide-left-leave-active,
.slide-right-enter {
  opacity: 0;
  transform: translate(-2em, 0);
}
</style>
