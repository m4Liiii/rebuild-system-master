<template>
    <Head title="زیادکردنی پسولەی پارە وەرگرتن" />
    <Modal
    :customClass="'mt-5'"
    :show="isShowVisible"
    @close="closeShow"
 >
    <div class="p-6">
        <h4 class="text-lg font-medium text-center text-gray-200">
           جۆری دراو <span>
             <span v-if="form.t_curr_op == 1">IQD</span>
             <span v-if="form.t_curr_op == 2">IRR</span>
             <span v-if="form.t_curr_op == 3">TRY</span>
         </span>
        </h4>
        <div class="mx-10 my-3 ">
            <InputLabel for="NameCustKo" value="بڕی وەرگرتن" />
            <TextInput
              id="NameCustKo"
              type="text"
              disabled
              placeholder="بڕی وەرگرتن"
              :value="formatNumber(CurrAmo)"
              class="w-full mt-1"
            />
          </div>
          <div class="mx-10 my-3 ">
            <InputLabel for="NameCustTak" value="بڕی داشکاندن" />
            <TextInput
              id="NameCustTak"
              disabled
              type="text"
              placeholder="بڕی داشکاندن"
              :value="formatNumber(CurrDis)"
              class="w-full mt-1"
            />
          </div>

          <div class="pt-10 mx-10 my-3 ">
            <InputLabel for="NameCustTak" value=" بڕی دراو بەرامبەر بە USD 1" />
            <TextInput
              id="NameCustTak"
              disabled
              type="text"
              placeholder="بڕ "
              :value="formatNumber(form.curr_op)"
              class="w-full mt-1"
            />
          </div>

        <div class="flex justify-center mt-6">
            <SecondaryButton @click="closeShow"> لابردن </SecondaryButton>
        </div>
    </div>
 </Modal>



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
            <InputLabel for="old_debt" class="relative" > قەرزی کۆن <span @click="trueShow" class="cursor-pointer text-cyan-400">V</span> </InputLabel>
            <TextInput
              id="old_debt"
              type="text"
              :value="formatNumber(props.offDebt.old_debt)"
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

                    <div class="px-3 text-cyan-300 whitespace-nowrap" v-if="props.offDebt.curr_op != 0">ئاگاداربە لە بڕی پارەدان بڕەکە ڕاستەوانەیە لەگەڵ پسولەی کڕینی ژمارە ( {{ props.offDebt.id_rep_conn }} )</div>

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
import Modal from "@/Components/Modal.vue";
import numeral from 'numeral';
import { format } from 'date-fns';

const office = usePage().props.office;
const props = defineProps({
    offDebt: Object,
 office: Object,
});
const formatPrice = (number) => {
  return number == null || isNaN(number) ? "0" : numeral(number).format('0.[000]');
};
const formatNumber = (number) => {
  return number == null || isNaN(number) ? "0" : numeral(number).format('0,0.[000]');
};


const createdDate = computed(() => {
  return format(new Date(props.offDebt.created_at), 'yyyy-MM-dd\'T\'HH:mm');
});
const form = useForm({
  old_debt: props.offDebt.old_debt,
  amount_of_debt: formatPrice(props.offDebt.amount_of_debt),
  discount: formatPrice(props.offDebt.discount),
  name_of_recipient: props.offDebt.name_of_recipient,
  notice_of_debt: props.offDebt.notice_of_debt,
  curr_op: props.offDebt.curr_op,
  t_curr_op: props.offDebt.t_curr_op,
  created_at: createdDate.value,
  type_amount: 0,
});

const submit = () => {
  form.put(route("offices.offdebts.update" , {office: office.id , offdebt:props.offDebt.id} ,{
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
    form.notice_of_debt = "";
    form.created_at = "";
    form.created_at = currentDate();
}



const new_debt = computed(() => {
  return form.old_debt - form.amount_of_debt - form.discount;
});

const CurrAmo = computed(() => {
   return form.amount_of_debt * form.curr_op;
});

const CurrDis = computed(() => {
   return form.discount * form.curr_op;
});

const trueShow = () => {
  isShowVisible.value = true;
};
const closeShow = () => {
  isShowVisible.value = false;
};
const isShowVisible = ref(false);

</script>
