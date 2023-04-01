<template>
  <q-btn
    color="negative"
    icon="delete_forever"
    :label="what ? `Delete ${what}` : undefined"
    no-caps
    @click="!$attrs.onClick && onClick()"
  />
</template>

<script setup>
import { Notify } from "quasar";
import { confirmAction } from "src/utils/dialogs.js";

const props = defineProps({
  what: String, // Name of entity being deleted
  delete: Function, // Callback function to do the actual delete
  noConfirm: Boolean, // Skip the "are you sure" confirmation dialog?
});

const onClick = async () => {
  if (props.what && !props.noConfirm) {
    await confirmAction(
      `Are you sure you want to delete this ${props.what}?`,
      `Delete ${props.what}`,
      "negative"
    );
  }

  let res = await props.delete();
  if (res !== false && props.what) Notify.create(`${props.what} deleted`);
};
</script>
