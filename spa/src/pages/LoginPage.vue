<template>
  <q-page class="flex flex-center">
    <div class="full-width" style="max-width: 300px">
      <h5 class="q-my-md">Login</h5>
      <q-card>
        <q-form @submit.prevent="login">
          <q-card-section>
            <custom-input
              v-model="form.mobile"
              type="text"
              label="Mobile or Email"
              placeholder="Enter a mobile or email address"
              class="q-mb-md"
              filled
            />
            <custom-input
              v-model="form.password"
              type="password"
              label="Password"
              placeholder="Enter password"
              class="q-mb-md"
              filled
            />
          </q-card-section>
          <q-btn
            type="submit"
            label="login"
            class="full-width"
            color="primary"
          />
        </q-form>
      </q-card>
    </div>
  </q-page>
</template>

<script setup>
import { ref, reactive } from "vue";
import { useQuasar } from "quasar";
import { post } from "src/utils/resources.js";
import { useAuthStore } from "src/stores/authStore";
import { useRouter } from "vue-router";
import { appUrl } from "src/consts";
const authStore = useAuthStore();
const isLoading = ref(false);
const form = reactive({});
const router = useRouter();
const login = async () => {
  try {
    isLoading.value = true;
    await authStore.login(form);
    router.push("/");
  } catch (error) {
    console.log(error);
  } finally {
    isLoading.value = false;
  }
};
</script>
