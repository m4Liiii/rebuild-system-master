<template>

    <AuthenticatedLayout>
        <div class="w-full py-3 mx-auto my-3 overflow-hidden rounded bg-zinc-700 lg:w-3/4">
            <span class="flex justify-center text-2xl text-gray-100 lg:text-4xl">زیاد کردنی پسولە</span>
            <div class="flex justify-center mb-4 text-center mt-7 text-cyan-400 animate-bounce">
        <svg width="66px" height="66px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 20L18 14M12 20L6 14M12 20L12 9.5M12 4V6.5" stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg></div>
    <button @click="submit" class="flex justify-center py-1 mx-auto text-5xl text-center text-gray-100 rounded w-52 bg-emerald-500 hover:bg-emerald-600"><CreateSvg/></button>

<div class="p-2 px-4">
    <div class="p-2 text-xl text-cyan-400 lg:text-2xl">تێبینی :-</div>
    <ul class="p-2 text-sm text-gray-100 lg:text-base">
        <li class="py-2">
           1- لە کاتی بوونی هەر کێشەیەک دەتوانی ئاگادارمان بکەیتەوە.
        </li>
        <li class="py-2">
            2- ئەم سیستەمە وا پڕۆگرام کراوە کە ئەگەر هەرچەندە داتا زۆربێ کار نەکاتە سەر خێرایی بۆیە تکایە هەموو کاتێک لە هێڵی ئینتەرنێتەکەت دڵنیابە.
        </li>
        <li class="py-2 ">
            3- هەر کێشەیەک لە پسولەکانت دا هەبوو ئەتوانی کلیک لە <span class="mx-0.5  px-1 bg-gray-600 rounded cursor-pointer text-indigo-300 hover:text-indigo-400">نوێکردنەوەی هەموو پسولەکان</span> بکەیت.
        </li>
    </ul>
</div>
</div>
</AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CreateSvg from "@/Components/Svg/Create.vue";
import LoaderDebtSvg from "@/Components/Svg/LoaderDebt.vue";
import { router, useForm } from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import {ref , computed} from "vue";
import SearchableProduct from "@/Components/Searchable-Product.vue";
import numeral from "numeral";
import SecondaryButton from "@/Components/SecondaryButton.vue";


const submit = () => {
  router.post(route("before.store.invoicebuy"));
};


</script>
