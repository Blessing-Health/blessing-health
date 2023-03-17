<template>
  <div class="row q-col-gutter-x-md items-center q-py-lg">
    <div class="col flex no-wrap wrap items-center">
      <q-icon
        :name="appStore.page.icon"
        size="xl"
        class="q-mx-sm gt-xs"
        color="primary"
      />

      <div>
        <div class="text-weight-medium">
          <template v-if="appStore.isLoading" />
          <span v-else-if="appStore.page.section">{{
            appStore.page.section
          }}</span>
          <span v-else-if="appStore.pageOffice">{{
            appStore.pageOffice.name
          }}</span>
          &nbsp;
        </div>

        <slide-transition :delay="40">
          <div :key="$route.name" class="text-h1 text-primary">
            <span v-if="appStore.isLoading">Loading...</span>
            <span v-else>{{ appStore.page.title }}</span>
          </div>
        </slide-transition>

        <slide-transition :delay="80">
          <div :key="$route.name" class="text-weight-medium">
            <template v-if="!appStore.isLoading">
              <q-icon name="chevron_right" class="q-mr-sm" />
              {{ appStore.fullPageSubtitle }}
            </template>
            &nbsp;
          </div>
        </slide-transition>
      </div>
    </div>

    <div class="col-auto gt-md">
      <q-breadcrumbs gutter="sm" separator="&bull;">
        <q-breadcrumbs-el
          v-for="breadcrumb in appStore.fullBreadcrumbs"
          :key="breadcrumb.label"
          v-bind="breadcrumb"
        />
      </q-breadcrumbs>
    </div>
  </div>
</template>

<script setup>
import SlideTransition from "components/interactions/SlideTransition.vue";
import { useAppStore } from "src/stores/appStore.js";

const appStore = useAppStore();
</script>
