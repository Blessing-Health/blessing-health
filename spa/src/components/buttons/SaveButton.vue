<template>
  <q-btn
    color="positive"
    :icon="isSaving ? 'hourglass_empty' : 'done'"
    type="submit"
    :disable="isSaving"
    :label="isSaving ? 'Saving...' : `Save ${what}`"
    no-caps
    @click="save && onClick()"
  />
</template>

<script setup>
import { Notify } from "quasar";

const props = defineProps({
  what: String, // Name of entity being deleted
  save: Function, // Optional callback function to do the actual save
  isSaving: Boolean,
});

const onClick = async () => {
  let res = await props.save();
  if (res !== false)
    Notify.create(`The ${props.what} was saved successfully`.toLowerCase());
};
</script>
