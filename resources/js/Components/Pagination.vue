<template>
  <Link
    preserve-scroll
    preserve-state
    replace
    :class="[
      meta.current_page == meta.last_page
        ? 'text-zinc-500 border-zinc-500 opacity-50 pointer-events-none'
        : 'text-zinc-300 active:border-cyan-500 active:text-cyan-500 border-zinc-300',
    ]"
    :href="links.last || 'javascript:void(0)'"
    @click.prevent="meta.current_page == meta.last_page"
    class="flex pt-1 pl-2 pr-5 border rounded-lg"
  >
    <div class="flex -mx-3">
      <svg width="21px" height="21px" viewBox="0 0 24 24" fill="none">
        <path
          d="M9 20L17 12M9 4L14 9"
          stroke="currentColor"
          stroke-width="1.5"
          stroke-linecap="round"
          stroke-linejoin="round"
        />
      </svg>
    </div>
    <svg width="21px" height="21px" viewBox="0 0 24 24" fill="none">
      <path
        d="M9 20L17 12M9 4L14 9"
        stroke="currentColor"
        stroke-width="1.5"
        stroke-linecap="round"
        stroke-linejoin="round"
      /></svg
  ></Link>
  <span class="mx-1"></span>
  <Link
    preserve-scroll
    preserve-state
    replace
    :class="[
      meta.current_page == meta.last_page
        ? 'text-zinc-500 border-zinc-500'
        : 'text-zinc-300 active:border-cyan-500 active:text-cyan-500 border-zinc-300',
      !links.next ? 'opacity-50 pointer-events-none' : '',
    ]"
    :href="links.next || 'javascript:void(0)'"
    @click.prevent="!links.next"
    class="flex pt-1 pl-3 pr-3 border rounded-lg"
    ><svg width="21px" height="21px" viewBox="0 0 24 24" fill="none">
      <path
        d="M9 20L17 12M9 4L14 9"
        stroke="currentColor"
        stroke-width="1.5"
        stroke-linecap="round"
        stroke-linejoin="round"
      /></svg
  ></Link>
  <div class="pt-0.5 mx-3 text-lg text-center text whitespace-nowrap">
    {{ meta.last_page }} / {{ meta.current_page }}
  </div>
  <Link
    preserve-scroll
    preserve-state
    replace
    :class="[
      meta.current_page == 1
        ? 'text-zinc-500 border-zinc-500 opacity-50 pointer-events-none'
        : 'text-zinc-300 active:border-cyan-500 active:text-cyan-500 border-zinc-300',
    ]"
    :href="links.prev || 'javascript:void(0)'"
    @click.prevent="meta.current_page == 1"
    class="flex pt-1 pl-3 pr-3 border rounded-lg"
  >
    <svg width="21px" height="21px" viewBox="0 0 24 24" fill="none">
      <path
        d="M15 4L10 9M7 12L15 20"
        stroke="currentColor"
        stroke-width="1.5"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
    </svg>
  </Link>
  <span class="mx-1"></span>
  <Link
    preserve-scroll
    preserve-state
    replace
    :class="[
      meta.current_page == 1
        ? 'text-zinc-500 border-zinc-500 opacity-50 pointer-events-none'
        : 'text-zinc-300 active:border-cyan-500 active:text-cyan-500 border-zinc-300',
    ]"
    :href="links.first || 'javascript:void(0)'"
    @click.prevent="meta.current_page == 1"
    class="flex pt-1 pl-2 pr-5 border rounded-lg border-zinc-300"
  >
    <div class="flex -mx-3">
      <svg width="21px" height="21px" viewBox="0 0 24 24" fill="none">
        <path
          d="M15 4L10 9M7 12L15 20"
          stroke="currentColor"
          stroke-width="1.5"
          stroke-linecap="round"
          stroke-linejoin="round"
        />
      </svg>
    </div>
    <svg width="21px" height="21px" viewBox="0 0 24 24" fill="none">
      <path
        d="M15 4L10 9M7 12L15 20"
        stroke="currentColor"
        stroke-width="1.5"
        stroke-linecap="round"
        stroke-linejoin="round"
      /></svg
  ></Link>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  links: Object,
  meta: Object,
});
</script>
