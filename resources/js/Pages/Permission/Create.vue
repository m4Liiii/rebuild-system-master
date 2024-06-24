<template>
  <Head title="زیادکردنی رۆڵ" />
    <AuthenticatedLayout>

      <div class="flex items-center p-4 py-7">
          <Link
          :href="route('roles.index')"
          class="inline-block p-2 rounded-r text-rose-300 bg-zinc-600"
        >
         <BackSvg/>
        </Link>
          <div class="justify-end p-4 text-left rounded-l text-emerald-400 bg-zinc-700">
              فۆڕمی زیاد کردنی ڕۆڵ
          </div>


      </div>


      <form @submit.prevent="submit">
        <div class="p-4 mx-4 rounded-lg shadow-md bg-zinc-700">
          <div class="flex flex-wrap justify-center flex-initial m-2 m">

            <div class="my-3 lg:w-2/5">
              <InputLabel for="name1" value="ناو" class="relative" />
              <TextInput
                id="name1"

                type="text"
                v-model="form.name"

                class="w-full mt-1"
                placeholder="ناوی ڕۆڵ بنوسە"

              />
              <InputError class="mt-2"   :message="form.errors.name ? '  هەڵە هەیە لە ناوی بەکارهێنەر' : ''" />
            </div>
          </div>
          <div class="flex justify-center py-5">
            <SecondaryButton @click="resetForm" class="mx-2">بەتاڵ کردنەوە</SecondaryButton>
            <PrimaryButton :disabled="form.processing" class="mx-2">زەخیرەکردن</PrimaryButton>
          </div>
        </div>
      </form>
    </AuthenticatedLayout>
  </template>
  <script setup>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import InputError from "@/Components/InputError.vue";
  import InputLabel from "@/Components/InputLabel.vue";
  import PrimaryButton from "@/Components/PrimaryButton.vue";
  import SecondaryButton from "@/Components/SecondaryButton.vue";
  import TextInput from "@/Components/TextInput.vue";
  import BackSvg from "@/Components/Svg/Back.vue";
  import { Head, Link, useForm } from "@inertiajs/vue3";

  const form = useForm({
    name: "",
  });

  const submit = () => {
    form.post(route("roles.store"));
  };

  function resetForm() {
      form.name = "";
  }

  </script>
