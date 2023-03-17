<template>
  <q-layout view="lHh Lpr lFf">
    <top-bar />
    <side-bar />

    <q-page-container>
      <div class="q-px-md q-pb-xl" style="overflow: hidden">
        <page-title />
        <router-view #default="{ Component }">
          <page-transition>
            <component :is="Component" />
          </page-transition>
        </router-view>
      </div>
    </q-page-container>
  </q-layout>
</template>

<script setup>
import PageTitle from "./common/PageTitle.vue";
import PageTransition from "./common/PageTransition.vue";
import SideBar from "./sidebar/SideBar.vue";
import TopBar from "./topbar/TopBar.vue";
</script>
