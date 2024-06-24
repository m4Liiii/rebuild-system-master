<template>
    <Head title="زیادکردنی بەکارهێنەر" />

  <AuthenticatedLayout>

    <div class="flex items-center p-4 py-7">
        <Link
        :href="route('users.index')"
        class="inline-block p-2 rounded-r text-rose-300 bg-zinc-600"
      >
       <BackSvg/>
      </Link>
        <div class="justify-end p-4 text-left rounded-l text-emerald-400 bg-zinc-700">
            فۆڕمی زیاد کردنی بەکارهێنەر
        </div>


    </div>


    <form @submit.prevent="submit">
      <div class="p-4 mx-4 rounded-lg shadow-md bg-zinc-700 mb-7">
        <div class="flex flex-wrap justify-center flex-initial m-2 m">

          <div class="mx-2 my-3 lg:w-2/5">
            <InputLabel for="name1" value="ناو" class="relative" />
            <TextInput
              id="name1"

              type="text"
              v-model="form.name"

              class="w-full mt-1"
              placeholder="ناوی بەکارهێنەر بنوسە"

            />
            <InputError class="mt-2"   :message="form.errors.name ? '  هەڵە هەیە لە ناوی بەکارهێنەر' : ''" />
          </div>
        </div>
        <div class="flex flex-wrap justify-center flex-initial m-2">
          <!-- First Pair -->
          <div class="mx-2 my-3 lg:w-2/5">
            <InputLabel for="name4" value="وشەی نهێنی" class="relative" />
            <TextInput
              id="name4"
              type="text"
              v-model="form.password"
              class="w-full mt-1"
              placeholder=" لە 8 پیت یان ژمارە یان هێما کەمتر نەبێت"

            />
            <InputError class="mt-2"  :message="form.errors.password ? '  هەڵە هەیە لە وشەی نهێنی' : ''"/>
          </div>

          <!-- Second Pair -->
          <div class="mx-2 my-3 lg:w-2/5">
            <InputLabel for="name2" value="دڵنیا بونەوەی ژمارەی نهێنی" />
            <TextInput
              id="name2"
              type="text"
              v-model="form.password_confirmation"
              class="w-full mt-1"
              placeholder=" دڵنیا ببەوە لە ژمارەی نهێنیەکەت"

            />
            <InputError class="mt-2" :message="form.errors.password_confirmation ? '  هەڵە هەیە لە دڵنیا بونەوەی وشەی نهێنی' : ''"/>
          </div>
        </div>
        <div class="flex justify-center py-5 ml-4">
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
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("users.store") ,{
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};

function resetForm() {
    form.name = "";
    form.password = "";
    form.password_confirmation = "";
}

</script>
