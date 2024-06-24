<template>
    <div class="relative">
      <input
        ref="inputField"
        dir="RTL"
        type="text"
        v-model="search"
        @blur="closeDropdown"
        @focus="openDropdown"
        @input="filterOptions"
        @keydown.up.prevent="keyNavigate(-1)"
        @keydown.down.prevent="keyNavigate(1)"
        @keydown.enter.prevent="selectOption(filteredOptions[highlightedIndex])"
        :placeholder="'' + label"
        class="block w-full px-4 py-2 mt-1 text-sm leading-5 text-right focus:rounded-b-none bg-gray-600 focus:border-cyan-400 text-white placeholder-gray-300 focus:outline-none rounded focus:ring-0 border-gray-200 [-moz-appearance:_textfield] sm:text-sm [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none"
        :class="[inputClasses]"
      />
      <div
        v-if="deselectable"
        v-show="search"
        @click.prevent="deselect"
        :class="['absolute font-sans cursor-pointer top-0 left-4 text-rose-300 focus:outline-none', deselectButtonClass]"
        >
        X
      </div>

      <div
        v-show="dropdownOpen"
        class="absolute z-10 w-full mt-0.5 bg-gray-600 text-gray-100  border border-gray-200 rounded-md rounded-t-none shadow-lg scrollbar scrollbar-thin scrollbar-thumb-gray-500 scrollbar-track-indigo-500"
      >
        <ul
          ref="dropdown"
          class="overflow-auto text-gray-100 divide-y divide-gray-200 rounded-md rounded-t-none max-h-56 ring-1 ring-black ring-opacity-5"
        >
          <li
            v-for="(option, index) in filteredOptions"
            :key="option.id"
            @mousedown="selectOption(option)"
            @mouseover="highlightedIndex = index"
            :class="{
              'px-3 pt-0.5 text-right cursor-pointer hover:bg-gray-700': true,
              'bg-gray-700 ': index == highlightedIndex,
            }"
          >
            <slot name="option-content" :option="option">
              {{ option.name }}
            </slot>
          </li>
        </ul>
      </div>
    </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';

const emit = defineEmits(['update:modelValue', 'onMount']);

const props = defineProps({
  inputClasses: {
    type: String,
    default: "",
  },
  searchFields: {
    type: Array,
    default: () => [],
  },
  items: {
    type: Array,
    required: true,
  },
  label: {
    type: String,
    default: "",
  },
  modelValue: {
    type: [String, Number],
    default: "",
  },
  deselectable: {
        type: Boolean,
        default: false,
    },
    deselectButtonClass: {
    type: String,
    default: '',
  },
});

const highlightedIndex = ref(-1);
const search = ref("");
const dropdownOpen = ref(false);
const filteredOptions = ref([]);

watch(() => props.items, (newValue) => {
  filteredOptions.value = newValue;
}, { immediate: true });

const filterOptions = () => {
  const searchValue = search.value.toLowerCase();
  filteredOptions.value = props.items.filter((item) =>
    props.searchFields.some((field) =>
      item[field] && item[field].toString().toLowerCase().includes(searchValue))
  );
};


const keyNavigate = (delta) => {
  highlightedIndex.value =
    (highlightedIndex.value + delta + filteredOptions.value.length) % filteredOptions.value.length;
};

const deselect = () => {
  emit("update:modelValue", "");
  search.value = "";
  dropdownOpen.value = false;
};

const selectOption = (option) => {
  const label = props.searchFields.map((field) => option[field]).join(" - ");
  search.value = label;
  emit("update:modelValue", option.id);
  dropdownOpen.value = false;
};

const openDropdown = () => {
  dropdownOpen.value = true;
};

const closeDropdown = () => {
  setTimeout(() => {
    dropdownOpen.value = false;
  }, 100);
};


onMounted(() => {
  filteredOptions.value = props.items;
});


</script>
