<template>
    <Head title="زیادکردنی پسولەی پارە وەرگرتن" />

  <AuthenticatedLayout>
<div class="justify-between md:flex ">
    <div class="flex items-center p-4 py-7">
        <Link
        :href="route('sellers.repdebts.index', seller.id)"
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
          {{ seller.name_seller }}
        </div>
    </div>

</div>

    <form @submit.prevent="submit">
      <div class="p-4 mx-4 rounded-lg shadow-md bg-zinc-700">
        <div class="flex flex-wrap justify-center flex-initial m-2 ">
          <!-- First Pair -->
          <div class="px-2 my-3 lg:w-1/4">
            <InputLabel for="old_debt" >قەرزی کۆن <span>
                <span v-if="seller.type_curr == 0">USD</span>
                <span v-if="seller.type_curr == 1">IQD</span>
                <span v-if="seller.type_curr == 2">IRR</span>
                <span v-if="seller.type_curr == 3">TRY</span>
            </span></InputLabel>
            <TextInput
              id="old_debt"
              type="text"
              :value="formatNumber(seller.debt_seller)"
              class="w-full mt-1"
              placeholder="قەرزی کۆن"
              readonly
            />
          </div>

          <!-- Second Pair -->
          <div class="px-2 my-3 lg:w-1/4">
            <InputLabel for="amount" >پارە وەرگرتن بە <span>
                <span v-if="seller.type_curr == 0">USD</span>
                <span v-if="seller.type_curr == 1">IQD</span>
                <span v-if="seller.type_curr == 2">IRR</span>
                <span v-if="seller.type_curr == 3">TRY</span>
            </span> {{ formatNumber(form.amount_of_debt) }}</InputLabel>
            <TextInput
              id="amount"
              maxLength="12"
              type="text"
              @input="calculateAmountCurr"
              v-model="form.amount_of_debt"
              class="w-full mt-1"
              placeholder="پارە وەرگرتن"
            />
            <InputError class="mt-2" :message="form.errors.amount_of_debt ? 'هەڵە هەیە لە پارە وەرگرتن' : ''"/>
          </div>


            <div class="px-2 my-3 lg:w-1/4">
              <InputLabel for="disc" class="relative"> داشکاندن بە <span>
                <span v-if="seller.type_curr == 0">USD</span>
                <span v-if="seller.type_curr == 1">IQD</span>
                <span v-if="seller.type_curr == 2">IRR</span>
                <span v-if="seller.type_curr == 3">TRY</span>
            </span> {{ formatNumber(form.discount) }}</InputLabel>
              <TextInput
                id="disc"
                type="text"
                maxLength="12"
                @input="calculateDiscountCurr"
                v-model="form.discount"
                class="w-full mt-1"
                placeholder="داشکاندن"
              />
              <InputError class="mt-2"  :message="form.errors.discount ? 'هەڵە هەیە لە داشکاندن' : ''"/>
            </div>

            <!-- Second Pair -->
            <div class="px-2 my-3 lg:w-1/4">
              <InputLabel for="p_tak" >بڕی ماوە <span>
                <span v-if="seller.type_curr == 0">USD</span>
                <span v-if="seller.type_curr == 1">IQD</span>
                <span v-if="seller.type_curr == 2">IRR</span>
                <span v-if="seller.type_curr == 3">TRY</span>
            </span></InputLabel>
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
          <div class="flex flex-wrap justify-center flex-initial m-2 " v-if="seller.type_curr != 0">
            <!-- First Pair -->
            <div class="px-2 my-3 lg:w-1/4">
              <InputLabel for="old_debt USD" value="قەرزی کۆن بە USD" class="relative" />
              <TextInput
                id="old_debt USD"
                type="text"
                :value="formatNumber(oldCurr)"
                class="w-full mt-1"
                placeholder="قەرزی کۆن بە USD"
                readonly
              />
            </div>

            <!-- Second Pair -->
            <div class="px-2 my-3 lg:w-1/4">
              <InputLabel for="amount USD" >پارە وەرگرتن بە USD {{ formatNumber(form.amount_curr) }}</InputLabel>
              <TextInput
                id="amount USD"
                maxLength="12"
                type="text"
                @input="calculateAmount"
                v-model="form.amount_curr"

                class="w-full mt-1"
                placeholder="پارە وەرگرتن بە USD"
              />
              <InputError class="mt-2" :message="form.errors.amount_curr ? 'هەڵە هەیە لە پارە وەرگرتن بە USD' : ''"/>
            </div>


              <div class="px-2 my-3 lg:w-1/4">
                <InputLabel for="disc" class="relative"> داشکاندن بە USD {{ formatNumber(form.discount_curr) }}</InputLabel>
                <TextInput
                  id="disc"
                  type="text"
                  maxLength="12"
                  @input="calculatediscount"
                  v-model="form.discount_curr"
                  class="w-full mt-1"
                  placeholder="داشکاندن بە USD"
                />
                <InputError class="mt-2"  :message="form.errors.discount_curr ? 'هەڵە هەیە لە داشکاندن بە USD' : ''"/>
              </div>

              <!-- Second Pair -->
              <div class="px-2 my-3 lg:w-1/4">
                <InputLabel for="p_tak" value="بڕی ماوە بە USD" />
                <TextInput
                  id="p_tak"
                  type="text"
                  :value="formatNumber(newCurr)"
                  class="w-full mt-1"
                  readonly
                  placeholder="بڕی ماوە بە USD"

                />
              </div>
            </div>

          <div class="flex flex-wrap justify-center flex-initial m-2">
            <!-- First Pair -->
            <div class="px-2 my-3 lg:w-1/2">
              <InputLabel for="mktaba"  class="relative" value="ناوی پارە دەر" />
              <TextInput
                id="mktaba"
                type="text"
                maxLength="50"
                v-model="form.name_of_office"
                class="w-full mt-1"
                placeholder="ناوی پارە دەر (ئارەزوومەندانە)"
              />
              <InputError class="mt-2"  :message="form.errors.name_of_office ? 'هەڵە هەیە لە ناوی پارە دەر' : ''"/>
            </div>
            <!-- Second Pair -->
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

          <div class="flex flex-wrap justify-center flex-initial m-2">
            <div class="px-2 my-3 lg:w-2/3">
                <InputLabel for="notice">پارەدان لە ڕێگەی نوسینگە  <span v-if="form.office_id != ''">( {{ officeName }} )</span></InputLabel>
                    <searchable-select
                    :items="props.offices"
                    :label="'پارەدان لە ڕێگەی نوسینگە'"
                    v-model="form.office_id"
                    :searchFields="['name_office']"
                    class="w-full"
                    :deselectable="true"
                    deselect-button-class="mt-1.5"

                   >
                    <template #option-content="{ option }">
                        {{ option.name_office }} - {{ option.phone_number }}
                    </template>
                   </searchable-select>
            </div>




              <div class="px-2 my-3 lg:w-1/3" v-if="seller.type_curr != 0">
                <InputLabel for="curr" class="relative"> نرخی <span>
                    <span v-if="seller.type_curr == 0">USD</span>
                    <span v-if="seller.type_curr == 1">IQD</span>
                    <span v-if="seller.type_curr == 2">IRR</span>
                    <span v-if="seller.type_curr == 3">TRY</span>
                </span></InputLabel>
                <TextInput
                  id="curr"
                  type="text"
                  maxLength="12"
                  @input="handleInputCurr"
                  v-model="form.curr"
                  class="w-full mt-1"
                  placeholder="نرخی دینار"
                />
                <InputError class="mt-2"  :message="form.errors.curr ? 'هەڵە هەیە لە داشکاندن' : ''"/>
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
import SearchableSelect from "@/Components/SearchableSelect.vue";
const seller = usePage().props.seller;
const props = defineProps({
 currency: Object,
 offices: Object,
});
const formatPrice = (number) => {
  return number == null || isNaN(number) ? "0" : numeral(number).format('0.[000]');
};
const formatNumber = (number) => {
  return number == null || isNaN(number) ? "0" : numeral(number).format('0,0.[000]');
};
const new_debt = computed(() => {
  return seller.debt_seller - form.amount_of_debt - form.discount;
});

const currentDate = () => {
  return format(new Date(),  'yyyy-MM-dd\'T\'HH:mm');
};
const setCurrency = (typeCurr) => {
  switch (typeCurr) {
    case 0:
      return props.currency.usd;
    case 1:
      return props.currency.iqd;
    case 2:
      return props.currency.irr;
    case 3:
      return props.currency.try;
    default:
      return null; // Or any default value you see fit
  }
};
const form = useForm({
  amount_of_debt: "",
  discount: "",
  name_of_recipient: "",
  name_of_office: "",
  notice_of_debt: "",
  office_id: "",
  discount_curr: "",
  amount_curr: "",
  curr: setCurrency(seller.type_curr),
  created_at: currentDate(),
  type_curr: seller.type_curr,
});

const submit = () => {
  form.post(route("sellers.repdebts.store" , seller.id));
};

function resetForm() {
    form.amount_of_debt = "";
    form.discount = "";
    form.name_of_recipient = "";
    form.name_of_office = "";
    form.notice_of_debt = "";
    form.created_at = "";
    form.curr = props.currency.iqd;
    form.created_at = currentDate();
}



const officeName = computed(() => {
      const office = props.offices.find(o => o.id === form.office_id);
      return office ? office.name_office : '';
    });


    const oldCurr = computed(() => {
  const oldDebt = parseFloat(seller.debt_seller);
  const typeCurr = parseFloat(form.curr);
  return !isNaN(oldDebt) && !isNaN(typeCurr) && typeCurr !== 0 ? oldDebt / typeCurr : 0;
});
const newCurr = computed(() => {
  const oldDebt = parseFloat(new_debt.value);
  const typeCurr = parseFloat(form.curr);
  return !isNaN(oldDebt) && !isNaN(typeCurr) && typeCurr !== 0 ? oldDebt / typeCurr : 0;
});

const calculateAmountCurr = () => {
  const amountOfDebt = parseFloat(form.amount_of_debt);
  if (!isNaN(amountOfDebt) && form.curr) {
    const calculatedValue = amountOfDebt / parseFloat(form.curr);
    form.amount_curr = formatPrice(calculatedValue);
  } else {
    form.amount_curr = "";
  }
};



const calculateAmount = () => {
  const amountcurr = parseFloat(form.amount_curr);
  if (!isNaN(amountcurr) && form.curr) {
    const calculatedcurr = amountcurr * parseFloat(form.curr);
    form.amount_of_debt = formatPrice(calculatedcurr);
  } else {
    form.amount_of_debt = "";
  }
};




const calculateDiscountCurr = () => {
  const discountOfDebt = parseFloat(form.discount);
  if (!isNaN(discountOfDebt) && form.curr) {
    const calculatedValue = discountOfDebt / parseFloat(form.curr);
    form.discount_curr = formatPrice(calculatedValue);
  } else {
    form.discount_curr = "";
  }
};



const calculatediscount = () => {
  const discountcurr = parseFloat(form.discount_curr);
  if (!isNaN(discountcurr) && form.curr) {
    const calculatedcurr = discountcurr * parseFloat(form.curr);
    form.discount = formatPrice(calculatedcurr);
  } else {
    form.discount = "";
  }
};

const handleInputCurr = () => {
  calculateDiscountCurr();
  calculateAmountCurr();
};
</script>
