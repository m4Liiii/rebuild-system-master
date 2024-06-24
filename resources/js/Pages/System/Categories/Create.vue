<template>
    <Head title="زیادکردنی جۆری بابەتەکان" />

  <AuthenticatedLayout>

    <div class="flex items-center p-4 py-7">
        <Link
        :href="route('categories.index')"
        class="inline-block p-2 rounded-r text-rose-300 bg-zinc-600"
      >
       <BackSvg/>
      </Link>
        <div class="justify-end p-4 text-left rounded-l text-emerald-400 bg-zinc-700">
            فۆڕمی زیاد کردنی جۆری بابەت
        </div>
    </div>


    <form @submit.prevent="submit">
      <div class="p-4 mx-4 rounded-lg shadow-md bg-zinc-700">
        <div class="flex flex-wrap justify-center flex-initial m-2">
          <!-- First Pair -->
          <div class="px-2 my-3 lg:w-1/2">
            <InputLabel for="name4" value=" ناوی جۆری بابەت" class="relative" />
            <TextInput
              id="name4"
              type="text"
              v-model="form.name"
              maxLength="35"
              class="w-full mt-1"
              placeholder="ناوی جۆری بابەت "

            />
            <InputError class="mt-2"  :message="form.errors.name ? '  هەڵە هەیە لە ناوی جۆری بابەت' : ''"/>
          </div>

          <!-- Second Pair -->
          <div class="px-2 my-3 lg:w-1/2">
            <InputLabel for="name2" value="   کۆدی جۆری بابەت" />
            <TextInput
              id="name2"
              type="text"
              maxLength="35"
              v-model="form.code"
              class="w-full mt-1"
              placeholder=" کۆدی جۆری بابەت  (ئارەزوومەندانە)"

            />
            <InputError class="mt-2" :message="form.errors.code ? '  هەڵە هەیە لە کۆدی جۆری بابەت' : ''"/>
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
  code: "",
  type_delete: "1",
});

const submit = () => {
  form.post(route("categories.store"));
};

function resetForm() {
    form.name = "";
    form.code = "";
}

</script>
