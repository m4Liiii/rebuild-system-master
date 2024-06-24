<template>
    <Head title="لیستی فرۆشیارەکان" />

    <Modal
    :customClass="'mt-36'"
    :show="isFilterVisible"
    @close="closeFilter"
 >
    <div class="p-6">
        <h4 class="text-lg font-medium text-center text-gray-200">
          فلتەر کردنی فرۆشیارەکان
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
              >کلیک بکە بۆ بینینی تەنها قەرزاریانی</label
            >
          </div>

        <div class="flex justify-center mt-6">

            <SecondaryButton @click="closeFilter"> لابردن </SecondaryButton>

            <DangerButton @click="resetSearch" class="mx-3 ml-3">بەتاڵ کردنەوە</DangerButton>

        </div>
    </div>
 </Modal>
   <Modal
   :show="showConfirmDeletesellerModal"
   @close="closeModal"
>
   <div class="p-6">
       <h2 class="text-lg font-medium text-gray-200">
              ئایا تۆ دڵنیای لە سڕینەوەی کڕیاری ( {{ sellerToDelete ? sellerToDelete.name_seller : '' }} ) ؟
       </h2>
       <div class="flex justify-end mt-6">

           <SecondaryButton @click="closeModal"> لابردن </SecondaryButton>

           <DangerButton  class="mx-3 ml-3" @click="deleteseller(sellerIdToDelete.value),closeModal()">سڕینەوە</DangerButton>

       </div>
   </div>
</Modal>
 <AuthenticatedLayout :searchValue="search" @updateSearchValue="handleSearchUpdate">

   <main class="h-full overflow-y-auto py-7">
     <div class="container grid px-6 mx-auto">
        <div class="items-center md:flex md:justify-between">
       <div class="flex items-center pb-7">
           <Link
           v-if="hasPermission('create_seller')"
           :href="route('sellers.create')"
           class="inline-block p-2 rounded-r text-emerald-500 bg-zinc-600"
         >
          <CreateSvg/>
         </Link>
           <div class="justify-end p-4 text-left rounded-l text-cyan-400 bg-zinc-700">
                 لیستی فرۆشیارەکان
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
                    </div>
                </TransitionDown>
            </div>
        </div>

       <div class="w-full overflow-hidden rounded-[5px] shadow-xs">
         <div class="w-full overflow-x-auto">
           <Table>
             <TableHead>
               <TableRowHead>
                 <TableDataHead class="w-32">#</TableDataHead>
                 <TableDataHead class="w-64">ناو</TableDataHead>
                 <TableDataHead class="w-32">بڕی قەرز</TableDataHead>
                 <TableDataHead class="w-32">جۆری دراو</TableDataHead>
                 <TableDataHead class="w-32">ناونیشان</TableDataHead>
                 <TableDataHead class="w-32">ژمارەی مۆبایل</TableDataHead>
                 <TableDataHead class="w-32">ژمارەی WH</TableDataHead>
                 <TableDataHead v-if="hasPermission('delete_seller')" class="w-10"></TableDataHead>
                 <TableDataHead  v-if="hasPermission('edit_seller')" class="w-10"></TableDataHead>
               </TableRowHead>
             </TableHead>
             <TableBody>
               <TableRow  @click="navigateTorepDebts(seller)" class="cursor-pointer " v-for="(seller, index) in sellers.data" :key="seller.id">
                <TableData     :class="{
                        'text-rose-300': seller.debt_seller > 0,
                        'text-gray-100 ': seller.debt_seller <= 0,
                      }" class="w-32">{{ index + 1}}</TableData>
                 <TableData     :class="{
                        'text-rose-300': seller.debt_seller > 0,
                        'text-gray-100 ': seller.debt_seller <= 0,
                      }" class="w-64">{{ seller.name_seller }}</TableData>
                 <TableData     :class="{
                        'text-rose-300': seller.debt_seller > 0,
                        'text-gray-100 ': seller.debt_seller <= 0,
                      }" class="w-32">{{ formatNumber(seller.debt_seller)}}</TableData>
                      <TableData     :class="{
                        'text-rose-300': seller.debt_seller > 0,
                        'text-gray-100 ': seller.debt_seller <= 0,
                      }" class="w-32"><span v-if="seller.type_curr == 0">USD</span>
                    <span v-if="seller.type_curr == 1">IQD</span>
                <span v-if="seller.type_curr == 2">IRR</span>
            <span v-if="seller.type_curr == 3">TRY</span></TableData>
                      <TableData     :class="{
                        'text-rose-300': seller.debt_seller > 0,
                        'text-gray-100 ': seller.debt_seller <= 0,
                      }" class="w-32">{{ seller.address }}</TableData>
                 <TableData     :class="{
                        'text-rose-300': seller.debt_seller > 0,
                        'text-gray-100 ': seller.debt_seller <= 0,
                      }" class="w-32">{{ seller.phone_number }}</TableData>
                 <TableData     :class="{
                        'text-rose-300': seller.debt_seller > 0,
                        'text-gray-100 ': seller.debt_seller <= 0,
                      }" class="w-32">{{ seller.social_number }}</TableData>

                 <TableData   @click.stop  v-if="hasPermission('delete_seller')" class="w-10 whitespace-nowrap" ><button    @click="confirmDeleteseller(seller.id)" class=" text-rose-300"><DeleteSvg/></button>
                </TableData>
                <TableData   @click.stop    v-if="hasPermission('edit_seller')" class="w-10 whitespace-nowrap" >
                    <Link    :href="route('sellers.edit' , seller.id)" class="inline-flex text-emerald-400"><EditSvg/></Link>
                 </TableData>



               </TableRow>
             </TableBody>
           </Table>
         </div>
         <div
           class="lg:flex px-6 py-1.5 text-xs text-gray-400 bg-zinc-700 border-t border-gray-700"
         >
           <div class="flex justify-start mt-1.5 pb-1.5">
             <Pagination :links="sellers.links" :meta="sellers.meta" />
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
 sellers: Object,
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

const { hasPermission } = usePermission();

const isDropdownVisible = ref(false)


const trueFilter = () => {
  isFilterVisible.value = true;
};
const closeFilter = () => {
  isFilterVisible.value = false;
};
const isFilterVisible = ref(false);





const typeseller = ref(props.sellers.typeseller);
const OnlyDebtors = ref(props.sellers.OnlyDebtors);
const search = ref(props.sellers.search);
const searchPhone = ref(props.sellers.searchPhone);
const searchName = ref(props.sellers.searchName);
const searchAddress = ref(props.sellers.searchAddress);

const handleSearchUpdate = (value) => {
 search.value = value;
};

watch([search, OnlyDebtors , searchAddress, searchPhone, searchName , typeseller], debounce(([newSearch, newOnlyDebtors , newSearchAddress, newSearchPhone , newSearchName , newtypeseller]) => {
  // Using newSearch and newOnlyDebtors to ensure we're passing the updated values
  router.get(
    route("sellers.index"),
    {
        search: newSearch,
        searchName: newSearchName,
        searchPhone: newSearchPhone,
      searchAddress : newSearchAddress,
      OnlyDebtors: newOnlyDebtors ? 'greater' : 'all',
      typeseller: newtypeseller
    },
    {
      preserveState: true,
      replace: true,
    }
  );
}, 100));


const repDebtStore = (id) => {
   form.post(route('sellers.repdebt.store', { seller: sellerIdToStore.value }), {
    onSuccess: () => {
      form.reset();
      closerepDebt();
    },
   preserveState: true,
 });
};

const deleteseller = (id) => {
   router.put(route('seller.type_delete', { seller: sellerIdToDelete.value }), {
   preserveState: true,
 });
};


// this is for false to true
const showConfirmDeletesellerModal = ref(false);

//this is for add id user you want
const sellerIdToDelete = ref(null);

const sellerIdToStore = ref(null);





// //thi is open by id
const confirmDeleteseller = (id) => {
   sellerIdToDelete.value = id;
   showConfirmDeletesellerModal.value = true;
};

// // this is for close
const closeModal = () => {
   showConfirmDeletesellerModal.value = false;
};

// //find data by id
const sellerToDelete = computed(() => {
   return props.sellers.data.find(seller => seller.id == sellerIdToDelete.value);
});



const resetSearch = () => {
  isFilterVisible.value = false;
  search.value = "";
  searchName.value = "";
  searchPhone.value = "";
  searchAddress.value = "";
  OnlyDebtors.value = "";
  typeseller.value = "1";
};

function navigateTorepDebts(seller) {
  router.get(route('sellers.repdebts.index', seller.id))
}


</script>
