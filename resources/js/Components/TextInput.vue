<script setup>
import { onMounted, ref } from "vue";

defineProps({
  modelValue: {
    type: String,
    required: true,
  },
});

defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
  if (input.value.hasAttribute("autofocus")) {
    input.value.focus();
  }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
  <input
    class="bg-gray-100 border-gray-300 rounded-md shadow-sm text-cyan-800 focus:border-cyan-500 focus:ring-cyan-500"
    :value="modelValue"
    autocomplete="off"
    @input="$emit('update:modelValue', $event.target.value)"
    ref="input"
  />
</template>
