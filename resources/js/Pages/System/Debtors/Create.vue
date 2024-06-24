<template>
    <Head title="زیادکردنی قەرزەکان" />

  <AuthenticatedLayout>
<div class="pb-10">
    <div class="flex items-center p-4 py-7">
        <Link
        :href="route('debtors.index')"
        class="inline-block p-2 rounded-r text-rose-300 bg-zinc-600"
      >
       <BackSvg/>
      </Link>
        <div class="justify-end p-4 text-left rounded-l text-emerald-400 bg-zinc-700">
            فۆڕمی زیاد کردنی قەرز
        </div>


    </div>


    <form @submit.prevent="submit">
      <div class="p-4 mx-4 rounded-lg shadow-md bg-zinc-700">
        <div class="flex flex-wrap justify-center flex-initial m-2">
          <!-- First Pair -->
          <div class="px-2 my-3 lg:w-1/2">
            <InputLabel for="name_debtor4" value="ناوی قەرز" class="relative" />
            <TextInput
              id="name_debtor4"
              type="text"
              maxLength="35"
              v-model="form.name_debtor"
              class="w-full mt-1"
              placeholder="ناوی قەرز"

            />
            <InputError class="mt-2"  :message="form.errors.name_debtor ? 'هەڵە هەیە لە ناوی قەرز' : ''"/>
          </div>

          <!-- Second Pair -->
          <div class="px-2 my-3 lg:w-1/2">
            <InputLabel for="debt" >قەرزی کۆن {{ formatNumber(form.debt_debtor) }}</InputLabel>
            <TextInput
              id="debt"
              maxLength="12"
              type="text"
              v-model="form.debt_debtor"
              class="w-full mt-1"
              placeholder="قەرزی کۆن (ئارەزوومەندانە , 0)"

            />
            <InputError class="mt-2" :message="form.errors.debt_debtor ? 'هەڵە هەیە لە قەرزی کۆن' : ''"/>
          </div>
        </div>
        <div class="flex flex-wrap justify-center flex-initial m-2">
            <!-- First Pair -->
            <div class="px-2 my-3 lg:w-1/2">
              <InputLabel for="phone_number4" value="ژمارەی مۆبایل" class="relative" />
              <TextInput
                id="phone_number4"
                type="text"
                maxLength="35"
                v-model="form.phone_number"
                class="w-full mt-1"
                placeholder="ژمارەی مۆبایل (ئارەزوومەندانە)"

              />
              <InputError class="mt-2"  :message="form.errors.phone_number ? '  هەڵە هەیە لە ژمارەی مۆبایل' : ''"/>
            </div>

            <!-- Second Pair -->
            <div class="px-2 my-3 lg:w-1/2">
              <InputLabel for="social_number2" value="ژ.مۆبایلی کۆمەڵایەتی" />
              <TextInput
                id="social_number2"
                type="text"
                maxLength="35"
                v-model="form.social_number"
                class="w-full mt-1"
                placeholder="ژ.مۆبایلی کۆمەڵایەتی (ئارەزوومەندانە)"

              />
              <InputError class="mt-2" :message="form.errors.social_number ? 'هەڵە هەیە لە ژ.مۆبایلی کۆمەڵایەتی' : ''"/>
            </div>
          </div>
          <div class="flex flex-wrap justify-center flex-initial m-2">
            <!-- First Pair -->
            <div class="px-2 my-3 lg:w-1/2">
                <InputLabel for="address2" value="ناونیشان" />
            <TextInput
              id="address2"
              type="text"
              maxLength="35"
              v-model="form.address"
              class="w-full mt-1"
              placeholder="ناونیشان (ئارەزوومەندانە)"

            />
            <InputError class="mt-2" :message="form.errors.address ? 'هەڵە هەیە لە ناونیشان' : ''"/>
            </div>

            <!-- Second Pair -->
            <div class="px-2 my-3 lg:w-1/2">
              <InputLabel for="alert2" value="دیاری کردنی ڕۆژی پارەدان" />
              <TextInput
                id="alert2"
                type="text"
                maxLength="9"
                v-model="form.alert_of_debt"
                class="w-full mt-1"
                placeholder="دیاری کردنی ڕۆژی پارەدان (ئارەزوومەندانە , 15)"

              />
              <InputError class="mt-2" :message="form.errors.social_number ? ' هەڵە هەیە لە دیاری کردنی ڕۆژی پارەدان' : ''"/>
            </div>
          </div>
          <div class="flex flex-wrap justify-center flex-initial m-2">
            <!-- First Pair -->
            <div class="px-2 my-3 lg:w-1/2">
              <InputLabel for="name4" value="تێبینی" class="relative" />
              <TextInput
                id="name4"
                type="text"
                maxLength="40"
                v-model="form.notice"
                class="w-full mt-1"
                placeholder="تێبینی (ئارەزوومەندانە)"
              />
              <InputError class="mt-2"  :message="form.errors.notice ? '  هەڵە هەیە لە تێبینی' : ''"/>
            </div>


          </div>


        <div class="flex justify-center py-5 ml-4">
          <SecondaryButton @click="resetForm" class="mx-2">بەتاڵ کردنەوە</SecondaryButton>
          <PrimaryButton :disabled="form.processing" class="mx-2">زەخیرەکردن</PrimaryButton>
        </div>
      </div>
    </form>
</div>
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
import numeral from 'numeral';


const formatNumber = (number) => {
  return number == null || isNaN(number) ? "-" : numeral(number).format('0,0.[000]');
};

const form = useForm({
    name_debtor: "",
    debt_debtor: "",
    alert_of_debt: "",
    address: "",
    phone_number: "",
    social_number: "",
    notice: "",
    type_delete: 1,
});

const submit = () => {
  form.post(route("debtors.store"));
};

function resetForm() {
    form.name_debtor = "";
    form.debt_debtor = "";
    form.alert_of_debt = "";
    form.address = "";
    form.phone_number = "";
    form.social_number = "";
    form.notice = "";
}

</script>
