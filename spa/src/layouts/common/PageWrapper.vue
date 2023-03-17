<template>
  <q-page>
    <slide-transition vertical>
      <div v-if="!appStore.isLoading" class="page-content">
        <slot />
      </div>
    </slide-transition>
    <q-page-sticky position="bottom-right" :offset="[18, 18]">
      <div class="q-gutter-x-sm">
        <slot name="page-actions" />
      </div>
    </q-page-sticky>
  </q-page>
</template>

<script setup>
// Wraps a q-page and only renders its content once the props.load() callback has been exectuted
// Saves us a little bit of common boilerplate where we need to wait for some data to load from the server
// before rendering the page content. Remember that its not recommended to stick v-if on a <q-page> as per Quasar docs
// For any form type pages use the similar FormWrapper.vue component instead
import SlideTransition from "src/components/interactions/SlideTransition.vue";
import { useAppStore } from "src/stores/appStore.js";
import { useAuthStore } from "src/stores/authStore.js";
import { onMounted, watch } from "vue";
import { useRouter } from "vue-router";

const props = defineProps({
  load: Function, // Callback to specify how the page should load its data
});

const appStore = useAppStore();
const authStore = useAuthStore();
const router = useRouter();

appStore.setLoading(true);

// When the selected offices changes we should trigger a reload of the page data (if scoped to the office)
watch(
  () => authStore.selectedOffice,
  () => {
    if (props.load && appStore.page.officeId) {
      props.load();
    }
  }
);

onMounted(async () => {
  appStore.setLoading(true);
  if (props.load) {
    try {
      await props.load();
    } catch (err) {
      router.back(); // Failed to load for some reason (error already shown) bail out
      throw err;
    }
  }
  appStore.setLoading(false);
});
</script>
