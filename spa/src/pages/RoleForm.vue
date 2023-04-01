<template>
  <form-wrapper
    entity-type-name="Role"
    section-name="Role Management"
    :listing-route="{ name: 'roles' }"
    :form="form"
    :save="saveRole"
  >
    <role-form-section :form="form" />
  </form-wrapper>
</template>
<script setup>
import { attachToFormData } from "src/utils/misc";
import { save } from "src/utils/resources";
import { reactive } from "vue";
import RoleFormSection from "./RoleFormSection.vue";

const props = defineProps({ id: [String, Number] });
const form = reactive({});

const saveRole = async () => {
  const res = await save(
    "roles",
    props.id,
    attachToFormData({
      ...form,
    })
  );
  return res;
};
</script>
