<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';



const open = ref(false);
</script>

<template>
    <div class="relative">
        <div @click="open = !open">
            <slot name="trigger" />
        </div>

        <!-- Full Screen Dropdown Overlay -->
        <div v-show="open" class="fixed inset-0 z-40 " @click="open = false"></div>

        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="scale-95 opacity-0"
            enter-to-class="scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="scale-100 opacity-100"
            leave-to-class="scale-95 opacity-0"
        >
            <div
                v-show="open"
                class="absolute z-50 mt-2 rounded-md w-22 bottom-10 "


                @click="open = false"
            >
                <div class="top-0 rounded " >
                    <slot class="hover:bg-gray-600" name="content" />
                </div>
            </div>
        </Transition>
    </div>
</template>
