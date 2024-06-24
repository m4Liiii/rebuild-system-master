<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'inline-flex  items-center w-full text-sm  text-cyan-500 transition-colors duration-150 hover:text-cyan-600'
        : 'inline-flex items-center w-full text-sm  text-gray-100 transition-colors duration-150 hover:text-gray-300'
);
</script>

<template>
    <ul class="my-2 mr-0.5">
      <li class="relative px-4 py-2">
                <span
                v-if="props.active"
                  class="absolute inset-y-0 right-0 w-1 rounded-tl-lg rounded-bl-lg bg-cyan-500"
                ></span>
    <Link :href="href" :class="classes">
              <slot />
    </Link>
        </li>
    </ul>
</template>
