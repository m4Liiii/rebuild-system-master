<template>
    <Head title="لیستی کڕیارەکان" />
    <Modal
    :customClass="'mt-16'"
    :show="isGetDebt"
    @close="closeGetDebt"
 >

    <div class="p-6">
        <h4 class="text-lg font-medium text-center text-gray-200">
          فۆڕمی پسولەی پارەدانی ( {{ customerToStore ? customerToStore.name_customer : '' }} )
        </h4>
        <div class="mx-10 my-3 ">
            <InputLabel for="old-2323" value="نرخی دینار " />
            <TextInput
              id="old-2323"
              type="text"
              v-model="form.curr"
              class="w-full mt-1"
              placeholder="نرخی دینار"
            />
          </div>
        <div class="mx-10 my-3 ">
            <InputLabel for="old-debt" value="قەرزی کۆن" />
            <TextInput
              id="old-debt"
              type="text"
              :value="formatNumber(customerToStore ? customerToStore.debt_customer : '')"
              class="w-full mt-1"
             readonly
              placeholder="قەرزی کۆن"
            />
          </div>
        <div class="mx-10 my-3 ">
            <InputLabel for="amount" value="بڕی پارەدان" />
            <TextInput
              id="amount"
              type="text"
              v-model="form.amount_of_debt"
              :readonly="shouldDisableAmountOfDebt"
              class="w-full mt-1"
              placeholder="بڕی پارەدان"

            />

          </div>

          <div class="mx-10 my-3 ">
            <InputLabel for="disc" value="داشکاندن" />
            <TextInput
              id="disc"
              type="text"
              v-model="form.discount"
              class="w-full mt-1"
              placeholder="داشکاندن"

            />

          </div>
          <div class="mx-10 my-3 ">
            <InputLabel for="new-d" value="بڕی ماوە" />
            <TextInput
              id="new-d"
              type="text"
              :value="new_debt"
              class="w-full mt-1"
              placeholder="بڕی ماوە"
            />

          </div>

          <div class="mx-10 border-white border-y">
          <div class="my-3 ">
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
          <div class="my-3 ">
            <InputLabel for="a_i_i"  class="relative">({{formatNumber(dinarAmountConverted)}} $) بڕی پارە وەرگرتن بە IQD
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
        </div>
          <div class="pt-10 mx-10 my-3">
            <InputLabel for="note" value="تێبینی" />
            <TextInput
              id="note"
              type="text"
              v-model="form.notice_of_debt"
              class="w-full mt-1"
              placeholder="تێبینی"
            />

          </div>
        <div class="flex justify-center mt-6">

            <SecondaryButton @click="closeGetDebt"> لابردن </SecondaryButton>

            <PrimaryButton @click="getDebtStore" class="mx-3 ml-3">زەخیرەکردن</PrimaryButton>

        </div>
    </div>
 </Modal>
    <Modal
    :customClass="'mt-36'"
    :show="isFilterVisible"
    @close="closeFilter"
 >
    <div class="p-6">
        <h4 class="text-lg font-medium text-center text-gray-200">
          فلتەر کردنی کڕیارەکان
        </h4>
        <div class="mx-10 my-3 ">
            <InputLabel for="NameADD" value="ناوی کڕیار" />
            <TextInput
              id="NameADD"
              maxLength="40"
              type="text"
              v-model="searchName"
              class="w-full mt-1"
              placeholder="گەڕان بۆ ناوی کڕیار"

            />

          </div>
        <div class="mx-10 my-3 ">
            <InputLabel for="social_number2" value="ناونیشان" />
            <TextInput
              id="social_number2"
              type="text"
              maxLength="40"
              v-model="searchAddress"
              class="w-full mt-1"
              placeholder="گەڕان بۆ ناونیشان"

            />

          </div>

          <div class="mx-10 my-3 ">
            <InputLabel for="social_number١" value="ژمارەی مۆبایل" />
            <TextInput
              id="social_number١"
              type="text"
              maxLength="40"
              v-model="searchPhone"
              class="w-full mt-1"
              placeholder="گەڕان بۆ ژمارەی مۆبایل"

            />

          </div>
          <div class="flex items-center pt-3 mx-10">
            <input
              v-model="OnlyDebtors"
              id="green-checkbox"
              type="checkbox"
              value=""
              class="w-5 h-5 border border-gray-300 rounded text-emerald-500 focus:ring-emerald-500 focus:ring-opacity-25"
            />
            <label
              for="green-checkbox"
              class="mr-5 text-sm font-medium text-gray-300"
              >کلیک بکە بۆ بینینی تەنها قەرزارەکان</label
            >
          </div>

        <div class="flex justify-center mt-6">

            <SecondaryButton @click="closeFilter"> لابردن </SecondaryButton>

            <DangerButton @click="resetSearch" class="mx-3 ml-3">بەتاڵ کردنەوە</DangerButton>

        </div>
    </div>
 </Modal>
   <Modal
   :show="showConfirmDeleteCustomerModal"
   @close="closeModal"
>
   <div class="p-6">
       <h2 class="text-lg font-medium text-gray-200">
              ئایا تۆ دڵنیای لە سڕینەوەی کڕیاری ( {{ customerToDelete ? customerToDelete.name_customer : '' }} ) ؟
       </h2>
       <div class="flex justify-end mt-6">

           <SecondaryButton @click="closeModal"> لابردن </SecondaryButton>

           <DangerButton  class="mx-3 ml-3" @click="deleteCustomer(customerIdToDelete.value),closeModal()">سڕینەوە</DangerButton>

       </div>
   </div>
</Modal>
 <AuthenticatedLayout :searchValue="search" @updateSearchValue="handleSearchUpdate">

   <main class="h-full overflow-y-auto py-7">
     <div class="container grid px-6 mx-auto">
        <div class="items-center md:flex md:justify-between">
       <div class="flex items-center pb-7">

           <Link
           v-if="hasPermission('create_customer')"
           :href="route('customers.create')"
           class="inline-block p-2 rounded-r text-emerald-500 bg-zinc-600"
         >

          <CreateSvg/>
         </Link>

           <div class="justify-end p-4 text-left text-cyan-400 bg-zinc-700">
                 لیستی کڕیارەکان
           </div>
           <div class="block p-1 mx-0.5 border-r rounded-l bg-zinc-700 border-zinc-600">
            <div class="flex items-center xl:mx-4">
             <input id="emerald-radio" type="radio" :value="1" checked v-model="typeCustomer" name="type-price-radio" class="w-4 h-4 text-emerald-600 focus:ring-emerald-600 ring-offset-gray-800 focus:ring-2">
             <label for="emerald-radio" class="mx-1 text-gray-300">کۆ</label>
         </div>
         <div class="flex items-center xl:mx-4">
             <input id="cyan-radio" type="radio" :value="0" v-model="typeCustomer" name="type-price-radio" class="w-4 h-4 text-cyan-600 focus:ring-cyan-600 ring-offset-gray-800 focus:ring-2">
             <label for="cyan-radio" class="mx-1 text-gray-300">تاک</label>
         </div>
     </div>

       </div>

        <div class="flex">
                <div v-if="!isDropdownVisible" @click="isDropdownVisible = !isDropdownVisible" class="p-2 text-sm font-medium transition rounded cursor-pointer bg-zinc-600 text-emerald-500 mb-7">
                    <OpenFiltSvg/>
                </div>
                <div v-if="isDropdownVisible" @click="isDropdownVisible = !isDropdownVisible" class="p-2 text-sm font-medium transition rounded cursor-pointer bg-zinc-600 text-rose-300 mb-7">
                    <CloseFiltSvg/>
                </div>
                <TransitionDown>
                    <div v-if="isDropdownVisible" class="absolute w-24 mt-16 rounded">
                        <BtnDown @click="trueFilter">
                            <FilterSvg/>
                        </BtnDown>
                        <BtnDown @click="toggleGetDebt">
                            <DollarSvg/>
                        </BtnDown>
                    </div>
                </TransitionDown>
            </div>
        </div>

       <div class="w-full overflow-hidden rounded-[5px] shadow-xs">
         <div class="w-full overflow-x-auto">
           <Table>
             <TableHead>
               <TableRowHead>
                <TableDataHead v-if="isGetDebtVisible" class="w-10"></TableDataHead>
                 <TableDataHead class="w-32">#</TableDataHead>
                 <TableDataHead class="w-64">ناو</TableDataHead>
                 <TableDataHead class="w-32">بڕی قەرز</TableDataHead>
                 <TableDataHead class="w-32">ناونیشان</TableDataHead>
                 <TableDataHead class="w-32">ژمارەی مۆبایل</TableDataHead>
                 <TableDataHead class="w-32">ژمارەی WH</TableDataHead>
                 <TableDataHead v-if="hasPermission('delete_customer')" class="w-10"></TableDataHead>
                 <TableDataHead v-if="hasPermission('delete_customer')" class="w-10"></TableDataHead>
                 <TableDataHead  v-if="hasPermission('edit_customer')" class="w-10"></TableDataHead>
               </TableRowHead>
             </TableHead>
             <TableBody>
               <TableRow  @click="navigateToGetDebts(customer)" class="cursor-pointer " v-for="(customer, index) in customers.data" :key="customer.id">
                <TableData  @click.stop   v-if="isGetDebtVisible" class="w-10 whitespace-nowrap" ><button    @click="trueGetDebt(customer.id)" class=" text-cyan-500"><DollarSvg/></button>
            </TableData>
                <TableData     :class="{
                        'text-rose-300': customer.debt_customer > 0,
                        'text-gray-100 ': customer.debt_customer <= 0,
                      }" class="w-32">{{ index + 1}}</TableData>
                 <TableData     :class="{
                        'text-rose-300': customer.debt_customer > 0,
                        'text-gray-100 ': customer.debt_customer <= 0,
                      }" class="w-64">{{ customer.name_customer }}</TableData>
                 <TableData     :class="{
                        'text-rose-300': customer.debt_customer > 0,
                        'text-gray-100 ': customer.debt_customer <= 0,
                      }" class="w-32">{{ formatNumber(customer.debt_customer)}}</TableData>
                 <TableData     :class="{
                        'text-rose-300': customer.debt_customer > 0,
                        'text-gray-100 ': customer.debt_customer <= 0,
                      }" class="w-32">{{ customer.address }}</TableData>
                 <TableData     :class="{
                        'text-rose-300': customer.debt_customer > 0,
                        'text-gray-100 ': customer.debt_customer <= 0,
                      }" class="w-32">{{ customer.phone_number }}</TableData>
                 <TableData     :class="{
                        'text-rose-300': customer.debt_customer > 0,
                        'text-gray-100 ': customer.debt_customer <= 0,
                      }" class="w-32">{{ customer.social_number }}</TableData>
                      <TableData @click.stop  class="w-10 whitespace-nowrap">
                        <Link :href="route('list.invoice.customer', { customer: customer.id })" class="inline-flex text-cyan-500">
                            <svg width="22px" height="22px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 4V7M19 14V20M19 14C20.1046 14 21 13.1046 21 12C21 10.8954 20.1046 10 19 10C17.8954 10 17 10.8954 17 12C17 13.1046 17.8954 14 19 14ZM12 10V16M12 16C10.8954 16 10 16.8954 10 18C10 19.1046 10.8954 20 12 20C13.1046 20 14 19.1046 14 18C14 16.8954 13.1046 16 12 16ZM12 4V7M5 11V20M7 6C7 7.10457 6.10457 8 5 8C3.89543 8 3 7.10457 3 6C3 4.89543 3.89543 4 5 4C6.10457 4 7 4.89543 7 6Z" stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                        </Link>
                      </TableData>
                 <TableData   @click.stop  v-if="hasPermission('delete_customer')" class="w-10 whitespace-nowrap" ><button    @click="confirmDeleteCustomer(customer.id)" class=" text-rose-300"><DeleteSvg/></button>
                </TableData>
                <TableData   @click.stop    v-if="hasPermission('edit_customer')" class="w-10 whitespace-nowrap" >
                    <Link    :href="route('customers.edit' , customer.id)" class="inline-flex text-emerald-400"><EditSvg/></Link>
                 </TableData>



               </TableRow>
             </TableBody>
           </Table>
         </div>
         <div
           class="lg:flex px-6 py-1.5 text-xs text-gray-400 bg-zinc-700 border-t border-gray-700"
         >
           <div class="flex justify-start mt-1.5 pb-1.5">
             <Pagination :links="customers.links" :meta="customers.meta" />
           </div>

           <span class="flex mr-auto">

           </span>
         </div>
       </div>
     </div>
   </main>

 </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link ,useForm} from "@inertiajs/vue3";
import { ref, watch,  computed  } from "vue";

import Pagination from "@/Components/Pagination.vue";
import Table from "@/Components/Table.vue";
import TableBody from "@/Components/TableBody.vue";
import TableData from "@/Components/TableData.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TableHead from "@/Components/TableHead.vue";
import TableRow from "@/Components/TableRow.vue";
import CreateSvg from "@/Components/Svg/Create.vue";
import DeleteSvg from "@/Components/Svg/Delete.vue";
import FilterSvg from "@/Components/Svg/Filter.vue";
import DollarSvg from "@/Components/Svg/Dollar.vue";
import BtnDown from "@/Components/BtnDown.vue";
import OpenFiltSvg from "@/Components/Svg/OpenFilt.vue";
import CloseFiltSvg from "@/Components/Svg/CloseFilt.vue";
import EditSvg from "@/Components/Svg/Edit.vue";
import TransitionDown from "@/Components/TransitionDown.vue";
import TableRowHead from "@/Components/TableRowHead.vue";
import TableDataHead from "@/Components/TableDataHead.vue";
import { router } from "@inertiajs/vue3";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import { debounce } from 'lodash';
import { usePermission } from "@/Composables/permissions";
import numeral from 'numeral';
import { format } from 'date-fns';
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
 customers: Object,
 currency: Object,
});

const currentDate = () => {
  return format(new Date(), 'yyyy-MM-dd');
};

const form = useForm({
  amount_of_debt: "",
  discount: "",
  name_of_recipient: "",
  name_of_office: "",
  notice_of_debt: "",
  amount_dollar: "",
  amount_dinar: "",
  curr: props.currency.iqd,
  created_at: currentDate(),
  type_amount: 0,
});

const formatNumber = (number) => {
  return number == null || isNaN(number) ? "-" : numeral(number).format('0,0.[000]');
};
const formatPrice = (number) => {
  return number == null || isNaN(number) ? "0" : numeral(number).format('0.[000]');
};
const { hasPermission } = usePermission();

const isDropdownVisible = ref(false)


const trueFilter = () => {
  isFilterVisible.value = true;
};
const closeFilter = () => {
  isFilterVisible.value = false;
};
const isFilterVisible = ref(false);





const typeCustomer = ref(props.customers.typeCustomer);
const OnlyDebtors = ref(props.customers.OnlyDebtors);
const search = ref(props.customers.search);
const searchPhone = ref(props.customers.searchPhone);
const searchName = ref(props.customers.searchName);
const searchAddress = ref(props.customers.searchAddress);

const handleSearchUpdate = (value) => {
 search.value = value;
};

watch([search, OnlyDebtors , searchAddress, searchPhone, searchName , typeCustomer], debounce(([newSearch, newOnlyDebtors , newSearchAddress, newSearchPhone , newSearchName , newtypeCustomer]) => {
  // Using newSearch and newOnlyDebtors to ensure we're passing the updated values
  router.get(
    route("customers.index"),
    {
        search: newSearch,
        searchName: newSearchName,
        searchPhone: newSearchPhone,
      searchAddress : newSearchAddress,
      OnlyDebtors: newOnlyDebtors ? 'greater' : 'all',
      typeCustomer: newtypeCustomer
    },
    {
      preserveState: true,
      replace: true,
    }
  );
}, 100));


const getDebtStore = (id) => {
   form.post(route('customers.getdebt.store', { customer: customerIdToStore.value }), {
    onSuccess: () => {
      form.reset();
      closeGetDebt();
    },
   preserveState: true,
 });
};

const deleteCustomer = (id) => {
   router.put(route('customer.type_delete', { customer: customerIdToDelete.value }), {
   preserveState: true,
 });
};


// this is for false to true
const showConfirmDeleteCustomerModal = ref(false);

//this is for add id user you want
const customerIdToDelete = ref(null);

const customerIdToStore = ref(null);


const isGetDebt = ref(false);
const trueGetDebt = (id) => {
    customerIdToStore.value = id;
    isGetDebt.value = true;
};
const closeGetDebt = () => {
    isGetDebt.value = false;
    form.reset();
};
const isGetDebtVisible = ref(false);

const toggleGetDebt = () => {
  isGetDebtVisible.value = !isGetDebtVisible.value;
};

// //thi is open by id
const confirmDeleteCustomer = (id) => {
   customerIdToDelete.value = id;
   showConfirmDeleteCustomerModal.value = true;
};

// // this is for close
const closeModal = () => {
   showConfirmDeleteCustomerModal.value = false;
};

// //find data by id
const customerToDelete = computed(() => {
   return props.customers.data.find(customer => customer.id == customerIdToDelete.value);
});
const customerToStore = computed(() => {
   return props.customers.data.find(customer => customer.id == customerIdToStore.value);
});

const new_debt = computed(() => {

  if (customerToStore.value && !isNaN(form.amount_of_debt) &&  !isNaN(form.discount)) {
    return customerToStore.value.debt_customer - form.amount_of_debt - form.discount;
  }
  return 0;
});
const resetSearch = () => {
  isFilterVisible.value = false;
  search.value = "";
  searchName.value = "";
  searchPhone.value = "";
  searchAddress.value = "";
  OnlyDebtors.value = "";
  typeCustomer.value = "1";
};

function navigateToGetDebts(customer) {
  router.get(route('customers.getdebts.index', customer.id))
}





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
</script>
