<template>
  <q-input
    v-if="
      type == 'text' ||
      type == 'email' ||
      type == 'number' ||
      type == 'password'
    "
    :label="label"
    :placeholder="placeholder"
    :model-value="modelValue"
    @update:model-value="emitValue"
    type
  />
</template>

<script setup>
const props = defineProps({
  modelValue: [String, Number, Boolean, Array],
  type: {
    type: String,
    default: "text",
  },
  label: String,
  placeholder: String,
});

const emit = defineEmits(["update:modelValue"]);

const emitValue = (newVal) => {
  switch (props.type) {
    case "number":
      return emit("update:model-value", parseFloat(newVal));
    default:
      return emit("update:model-value", newVal);
  }
};
</script>
