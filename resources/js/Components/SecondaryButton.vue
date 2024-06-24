<script setup>
defineProps({
  type: {
    type: String,
    default: "button",
  },
});
</script>

<template>
  <button
    :type="type"
    class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase bg-gray-200 border border-gray-300 rounded-md shadow-sm active:bg-gray-200 hover:bg-gray-300"
  >
    <slot />
  </button>
</template>
