<template>
    <div class="block text-left">
      <button @click="toggleDropdown" type="button" class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-100 border border-gray-100 rounded-md shadow-sm bg-zinc-700 active:border-cyan-500 active:text-cyan-500">
        {{ selectedOption.text }}
      </button>

      <div v-if="showDropdown" class="absolute my-2 rounded-md shadow-lg bg-zinc-700 ring-1 ring-black ring-opacity-5">
        <ul class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
          <li v-for="option in options" :key="option.value" @click="selectOption(option)" class="block w-full px-4 py-2 text-sm text-gray-100 cursor-pointer hover:bg bg-zinc-700 hover:bg-gray-600" role="menuitem">
            {{ option.text }}
          </li>
        </ul>
      </div>
    </div>
  </template>


<script setup>
import { ref, computed } from "vue";

const props = defineProps({
  value: {
    type: Number,
    default: 1
  },
  options: {
    type: Array,
    default: () => [
      { value: 1, text: "1" },
      { value: 2, text: "2" },
      { value: 3, text: "3" },
      { value: 4, text: "4" },
    ],
  },
});

const getPerPageFromURL = () => {
  const urlParams = new URLSearchParams(window.location.search);
  return Number(urlParams.get("perPage")) || props.value;
};

const selectedValue = ref(getPerPageFromURL());
const emit = defineEmits(["update:value"]);

const selectedOption = computed(() => {
  return props.options.find(option => option.value === selectedValue.value) || props.options[0];
});

const toggleDropdown = () => {
  showDropdown.value = !showDropdown.value;
};

const selectOption = (option) => {
  selectedValue.value = option.value;
  emit("update:value", option.value);
  showDropdown.value = false;
};

const showDropdown = ref(false);
</script>
