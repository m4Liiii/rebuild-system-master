<template>
    <Head title="زیادکردنی پسولەی پارە وەرگرتن" />

  <AuthenticatedLayout>
<div class="justify-between md:flex ">
    <div class="flex items-center p-4 py-7">
        <Link
        :href="route('offices.offdebts.index', office.id)"
        class="inline-block p-2 rounded-r text-rose-300 bg-zinc-600"
      >
       <BackSvg/>
      </Link>
        <div class="justify-end p-4 text-left rounded-l whitespace-nowrap text-emerald-400 bg-zinc-700">
            فۆڕمی زیادکردنی پسولەی پارە وەرگرتن
        </div>
    </div>
    <div class="flex items-center p-4 py-7">

        <div class="justify-end p-4 text-left rounded text-cyan-400 bg-zinc-700">
          {{ office.name_office }}
        </div>
    </div>

</div>

    <form @submit.prevent="submit">
      <div class="p-4 mx-4 rounded-lg shadow-md bg-zinc-700">
        <div class="flex flex-wrap justify-center flex-initial m-2 ">
          <!-- First Pair -->
          <div class="px-2 my-3 lg:w-1/4">
            <InputLabel for="old_debt" value="قەرزی کۆن" class="relative" />
            <TextInput
              id="old_debt"
              type="text"
              :value="formatNumber(office.debt_office)"
              class="w-full mt-1"
              placeholder="قەرزی کۆن"
              readonly
            />
          </div>

          <!-- Second Pair -->
          <div class="px-2 my-3 lg:w-1/4">
            <InputLabel for="amount" >پارە وەرگرتن {{ formatNumber(form.amount_of_debt) }}</InputLabel>
            <TextInput
              id="amount"
              maxLength="12"
              type="text"
              v-model="form.amount_of_debt"
              :readonly="shouldDisableAmountOfDebt"
              class="w-full mt-1"
              placeholder="پارە وەرگرتن"
            />
            <InputError class="mt-2" :message="form.errors.amount_of_debt ? 'هەڵە هەیە لە پارە وەرگرتن' : ''"/>
          </div>


            <div class="px-2 my-3 lg:w-1/4">
              <InputLabel for="disc" class="relative"> داشکاندن {{ formatNumber(form.discount) }}</InputLabel>
              <TextInput
                id="disc"
                type="text"
                maxLength="12"
                v-model="form.discount"
                class="w-full mt-1"
                placeholder="داشکاندن"
              />
              <InputError class="mt-2"  :message="form.errors.discount ? 'هەڵە هەیە لە داشکاندن' : ''"/>
            </div>

            <!-- Second Pair -->
            <div class="px-2 my-3 lg:w-1/4">
              <InputLabel for="p_tak" value="بڕی ماوە" />
              <TextInput
                id="p_tak"
                type="text"
                :value="formatNumber(new_debt)"
                class="w-full mt-1"
                readonly
                placeholder="بڕی ماوە"

              />
            </div>
          </div>

          <div class="flex flex-wrap justify-center flex-initial m-2">
            <div class="px-2 my-3 lg:w-1/2">
                <InputLabel for="alert" value="ناوی پارە وەرگر" />
                <TextInput
                  id="alert"
                  maxLength="50"
                  type="text"
                  v-model="form.name_of_recipient"
                  class="w-full mt-1"
                  placeholder="ناوی پارە وەرگر (ئارەزوومەندانە)"
                />
                <InputError class="mt-2" :message="form.errors.name_of_recipient ? '  هەڵە هەیە لە ناوی پارە وەرگر' : ''"/>
              </div>
            <!-- First Pair -->
            <div class="px-2 my-3 lg:w-1/2">
                <InputLabel for="date" value="بەروار" />
                <TextInput
                  id="date"
                  type="datetime-local"
                  v-model="form.created_at"
                  class="w-full mt-1"
                  placeholder="بەروار"

                />
                <InputError class="mt-2" :message="form.errors.created_at ? 'هەڵە هەیە لە بەروار' : ''"/>
              </div>

            <!-- Second Pair -->

          </div>
          <div class="flex flex-wrap justify-center flex-initial m-2">

            <div class="px-2 my-3 lg:w-full">
                <InputLabel for="notice" value="تێبینی" class="relative" />
                <TextInput
                  id="notice"
                  type="text"
                  maxLength="50"
                  v-model="form.notice_of_debt"
                  class="w-full mt-1"
                  placeholder="تێبینی (ئارەزوومەندانە)"

                />
                <InputError class="mt-2"  :message="form.errors.notice_of_debt ? 'هەڵە هەیە لە تێبینی' : ''"/>
            </div>

          </div>

          <div class="flex flex-wrap justify-center flex-initial ">
            <!-- First Pair -->
            <div class="pr-4 mt-3 lg:w-1/2">

            </div>
            <div class="px-2 mb-2 lg:w-1/2">
                <div class="flex items-center">

                  </div>
            </div>
          </div>
        <div class="flex justify-center py-5 ml-4">
          <SecondaryButton  @click="resetForm" class="mx-2">بەتاڵ کردنەوە</SecondaryButton>
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
import { Head, Link, useForm , usePage } from "@inertiajs/vue3";
import { computed ,ref , watch  } from 'vue';
import numeral from 'numeral';
import { format } from 'date-fns';

const office = usePage().props.office;
const props = defineProps({
 office: Object,
});
const formatPrice = (number) => {
  return number == null || isNaN(number) ? "0" : numeral(number).format('0.[000]');
};
const formatNumber = (number) => {
  return number == null || isNaN(number) ? "0" : numeral(number).format('0,0.[000]');
};


const currentDate = () => {
  return format(new Date(),  'yyyy-MM-dd\'T\'HH:mm');
};
const form = useForm({
  amount_of_debt: "",
  discount: "",
  name_of_recipient: "",
  notice_of_debt: "",
  created_at: currentDate(),
});

const submit = () => {
  form.post(route("offices.offdebts.store" , office.id));
};

function resetForm() {
    form.amount_of_debt = "";
    form.discount = "";
    form.name_of_recipient = "";
    form.notice_of_debt = "";
    form.created_at = "";


    form.created_at = currentDate();
}


const new_debt = computed(() => {

  return office.debt_office - form.amount_of_debt - form.discount;
});

</script>
