<template>
    <Head title="گۆڕینی پسولەی پارە وەرگرتن" />

  <AuthenticatedLayout>
<div class="justify-between md:flex">
    <div class="flex items-center p-4 py-7">
        <Link
        :href="route('customers.getdebts.index', customer.id)"
        class="inline-block p-2 rounded-r text-rose-300 bg-zinc-600"
      >
       <BackSvg/>
      </Link>
        <div class="justify-end p-4 text-left rounded-l whitespace-nowrap text-emerald-400 bg-zinc-700">
            فۆڕمی گۆڕینی پسولەی پارە وەرگرتن
        </div>
    </div>
    <div class="flex items-center p-4 py-7">

        <div class="justify-end p-4 text-left rounded text-cyan-400 bg-zinc-700">
          {{ customer.name_customer }}
        </div>
    </div>

</div>

    <form @submit.prevent="submit">
      <div class="p-4 mx-4 rounded-lg shadow-md bg-zinc-700">
        <div class="flex flex-wrap justify-center flex-initial m-2">
          <!-- First Pair -->
          <div class="px-2 my-3 lg:w-1/4">
            <InputLabel for="old_debt" value="قەرزی کۆن" class="relative" />
            <TextInput
              id="old_debt"
              type="text"
              :value="formatNumber(form.old_debt)"
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
            <div class="px-2 my-3 lg:w-1/3">
              <InputLabel for="a_d_i"  class="relative" >بڕی پارە وەرگرتن بە USD {{ formatNumber(form.amount_dollar) }}</InputLabel>
              <TextInput
                id="a_d_i"
                type="text"
                v-model="form.amount_dollar"
                class="w-full mt-1"
                placeholder="بڕی پارە وەرگرتن بە USD"
              />
              <InputError class="mt-2"  :message="form.errors.amount_dollar ? 'هەڵە هەیە لە بڕی پارە وەرگرتن بە USD' : ''"/>
            </div>

            <!-- Second Pair -->
            <div class="px-2 my-3 lg:w-1/3">
              <InputLabel for="a_i_i"  class="relative"  >({{formatNumber(dinarAmountConverted)}} $) بڕی پارە وەرگرتن بە IQD
              {{
                  formatNumber(form.amount_dinar)
              }} </InputLabel
          >
              <TextInput
                id="a_i_i"
                type="text"
                v-model="form.amount_dinar"
                class="w-full mt-1"
                placeholder="بڕی پارە وەرگرتن بە IQD"
              />
              <InputError class="mt-2"  :message="form.errors.amount_dinar ? 'هەڵە هەیە لە بڕی پارە وەرگرتن بە IQD' : ''"/>
            </div>


              <div class="px-2 my-3 lg:w-1/3">
                <InputLabel for="curr" class="relative"> نرخی دینار {{ formatNumber(form.curr) }}</InputLabel>
                <TextInput
                  id="curr"
                  type="text"
                  maxLength="12"
                  v-model="form.curr"
                  class="w-full mt-1"
                  placeholder="نرخی دینار"
                />
                <InputError class="mt-2"  :message="form.errors.curr ? 'هەڵە هەیە لە داشکاندن' : ''"/>
              </div>
            </div>
          <div class="flex flex-wrap justify-center flex-initial m-2">
            <!-- First Pair -->
            <div class="px-2 my-3 lg:w-1/2">
              <InputLabel for="mktaba"  class="relative" value="ناوی نوسینگە" />
              <TextInput
                id="mktaba"
                type="text"
                maxLength="50"
                v-model="form.name_of_office"
                class="w-full mt-1"
                placeholder="ناوی نوسینگە (ئارەزوومەندانە)"

              />
              <InputError class="mt-2"  :message="form.errors.name_of_office ? 'هەڵە هەیە لە ناوی نوسینگە' : ''"/>
            </div>

            <!-- Second Pair -->
            <div class="px-2 my-3 lg:w-1/2">
              <InputLabel for="alert" value="ناوی پارە وەرگر" />
              <TextInput
                id="alert"
                type="text"
                maxLength="50"
                v-model="form.name_of_recipient"
                class="w-full mt-1"
                placeholder="ناوی پارە وەرگر (ئارەزوومەندانە)"

              />
              <InputError class="mt-2" :message="form.errors.name_of_recipient ? '  هەڵە هەیە لە ناوی پارە وەرگر' : ''"/>
            </div>
          </div>
          <div class="flex flex-wrap justify-center flex-initial m-2">
            <!-- First Pair -->
            <div class="px-2 my-3 lg:w-1/2">
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

            <!-- Second Pair -->
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
          </div>

          <div class="flex flex-wrap justify-center flex-initial ">
            <!-- First Pair -->
            <div class="pr-4 mt-3 lg:w-1/2">
                <div class="flex items-center">
                    <input
                      v-model="if_Office"
                      id="green-checkbox"
                      type="checkbox"
                      class="w-5 h-5 border border-gray-300 rounded text-cyan-500 focus:ring-cyan-500 focus:ring-opacity-25"
                    />
                    <label
                      for="green-checkbox"
                      class="mr-3 text-sm font-medium text-gray-300 "
                      >پارەدان لە ڕێگەی نوسینگە</label
                    >
                  </div>
            </div>

            <!-- Second Pair -->
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
import { computed ,ref,watch  } from 'vue';
import numeral from 'numeral';
import { format } from 'date-fns';


const formatPrice = (number) => {
  return number == null || isNaN(number) ? "0" : numeral(number).format('0.[000]');
};

const customer = usePage().props.customer;

const props = defineProps({
    getDebt: Object,

});
const formatNumber = (number) => {
  return number == null || isNaN(number) ? "0" : numeral(number).format('0,0.[000]');
};
const new_debt = computed(() => {
  return form.old_debt - form.amount_of_debt - form.discount;
});

const createdDate = computed(() => {
  return format(new Date(props.getDebt.created_at), 'yyyy-MM-dd\'T\'HH:mm');
});
const form = useForm({
  old_debt: props.getDebt.old_debt,
  amount_of_debt: formatPrice(props.getDebt.amount_of_debt),
  discount: formatPrice(props.getDebt.discount),
  name_of_recipient: props.getDebt.name_of_recipient,
  name_of_office: props.getDebt.name_of_office,
  notice_of_debt: props.getDebt.notice_of_debt,
  created_at: createdDate.value,
  type_amount: props.getDebt.type_amount,
  curr: props.getDebt.curr,
  amount_dinar: props.getDebt.amount_dinar,
  amount_dollar: formatPrice(props.getDebt.amount_dollar),
});

const submit = () => {
  form.put(route("customers.getdebts.update" , {customer: customer.id , getdebt:props.getDebt.id} ,{
        preserveScroll: true,
        onError: (errors) => {
            form.errors = errors;
        },
  }));
};


function resetForm() {
    form.amount_of_debt = "";
    form.discount = "";
    form.name_of_recipient = "";
    form.name_of_office = "";
    form.notice_of_debt = "";
    form.created_at = "";
    form.type_amount = 0;
    form.amount_dollar = "";
    form.amount_dinar = "";
    form.curr = props.currency.iqd;
    form.created_at = currentDate();
}
const if_Office = computed({
  get: () => form.type_amount == 1,
  set: (value) => { form.type_amount = value ? 1 : 0; }
});

const updateAmountOfDebt = () => {
  const dollarAmount = parseFloat(form.amount_dollar) || 0;
  const dinarAmount = parseInt(form.amount_dinar) / form.curr || 0;
  const totalAmount = dollarAmount + dinarAmount;

  form.amount_of_debt = formatPrice(totalAmount);
};


watch([() => form.amount_dollar, () => form.amount_dinar, () => form.curr], updateAmountOfDebt);

const shouldDisableAmountOfDebt = computed(() => {
  const dollarAmount = parseFloat(form.amount_dollar);
  const dinarAmount = parseInt(form.amount_dinar);

  return (!isNaN(dollarAmount) && dollarAmount != 0) || (!isNaN(dinarAmount) && dinarAmount != 0);
});
//start//
const calculateDinarAmount = () => {
  const dinarAmount = parseInt(form.amount_dinar) / form.curr || 0;
  return dinarAmount;
};
const dinarAmountConverted = computed(() => {
  return calculateDinarAmount();
});
//end//
</script>
