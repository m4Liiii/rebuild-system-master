<template>
    <Head title="لیستی نوسینگەکان" />
    <Modal
    :customClass="'mt-36'"
    :show="isFilterVisible"
    @close="closeFilter"
 >
    <div class="p-6">
        <h4 class="text-lg font-medium text-center text-gray-200">
          فلتەر کردنی نوسینگەکان
        </h4>
        <div class="mx-10 my-3 ">
            <InputLabel for="NameADD" value="ناوی نوسینگە" />
            <TextInput
              id="NameADD"
              maxLength="40"
              type="text"
              v-model="searchName"
              class="w-full mt-1"
              placeholder="گەڕان بۆ ناوی نوسینگە"
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
   :show="showConfirmDeleteofficeModal"
   @close="closeModal"
>
   <div class="p-6">
       <h2 class="text-lg font-medium text-gray-200">
              ئایا تۆ دڵنیای لە سڕینەوەی نوسینگەی ( {{ officeToDelete ? officeToDelete.name_office : '' }} ) ؟
       </h2>
       <div class="flex justify-end mt-6">

           <SecondaryButton @click="closeModal"> لابردن </SecondaryButton>

           <DangerButton  class="mx-3 ml-3" @click="deleteoffice(officeIdToDelete.value),closeModal()">سڕینەوە</DangerButton>

       </div>
   </div>
</Modal>
 <AuthenticatedLayout :searchValue="search" @updateSearchValue="handleSearchUpdate">

   <main class="h-full overflow-y-auto py-7">
     <div class="container grid px-6 mx-auto">
        <div class="items-center md:flex md:justify-between">
       <div class="flex items-center pb-7">

           <Link
           v-if="hasPermission('create_office')"
           :href="route('offices.create')"
           class="inline-block p-2 rounded-r text-emerald-500 bg-zinc-600"
         >

          <CreateSvg/>
         </Link>

           <div class="justify-end p-4 text-left rounded-l text-cyan-400 bg-zinc-700">
                 لیستی نوسینگەکان
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
                <TableDataHead v-if="isGetDebtVisible" class="w-10"></TableDataHead>
                 <TableDataHead class="w-32">#</TableDataHead>
                 <TableDataHead class="w-64">ناو</TableDataHead>
                 <TableDataHead class="w-32">بڕی قەرز</TableDataHead>
                 <TableDataHead class="w-32">ناونیشان</TableDataHead>
                 <TableDataHead class="w-32">ژمارەی مۆبایل</TableDataHead>
                 <TableDataHead class="w-32">ژمارەی WH</TableDataHead>
                 <TableDataHead v-if="hasPermission('delete_office')" class="w-10"></TableDataHead>
                 <TableDataHead  v-if="hasPermission('edit_office')" class="w-10"></TableDataHead>
               </TableRowHead>
             </TableHead>
             <TableBody>
               <TableRow  @click="navigateToOffDebts(office)" class="cursor-pointer " v-for="(office, index) in offices.data" :key="office.id">
                <TableData  @click.stop   v-if="isGetDebtVisible" class="w-10 whitespace-nowrap" ><button    @click="trueGetDebt(office.id)" class=" text-cyan-500"><DollarSvg/></button>
            </TableData>
                <TableData     :class="{
                        'text-rose-300': office.debt_office > 0,
                        'text-gray-100 ': office.debt_office <= 0,
                      }" class="w-32">{{ index + 1}}</TableData>
                 <TableData     :class="{
                        'text-rose-300': office.debt_office > 0,
                        'text-gray-100 ': office.debt_office <= 0,
                      }" class="w-64">{{ office.name_office }}</TableData>
                 <TableData     :class="{
                        'text-rose-300': office.debt_office > 0,
                        'text-gray-100 ': office.debt_office <= 0,
                      }" class="w-32">{{ formatNumber(office.debt_office)}}</TableData>
                 <TableData     :class="{
                        'text-rose-300': office.debt_office > 0,
                        'text-gray-100 ': office.debt_office <= 0,
                      }" class="w-32">{{ office.address }}</TableData>
                 <TableData     :class="{
                        'text-rose-300': office.debt_office > 0,
                        'text-gray-100 ': office.debt_office <= 0,
                      }" class="w-32">{{ office.phone_number }}</TableData>
                 <TableData     :class="{
                        'text-rose-300': office.debt_office > 0,
                        'text-gray-100 ': office.debt_office <= 0,
                      }" class="w-32">{{ office.social_number }}</TableData>

                 <TableData   @click.stop  v-if="hasPermission('delete_office')" class="w-10 whitespace-nowrap" ><button    @click="confirmDeleteoffice(office.id)" class=" text-rose-300"><DeleteSvg/></button>
                </TableData>
                <TableData   @click.stop    v-if="hasPermission('edit_office')" class="w-10 whitespace-nowrap" >
                    <Link    :href="route('offices.edit' , office.id)" class="inline-flex text-emerald-400"><EditSvg/></Link>
                 </TableData>



               </TableRow>
             </TableBody>
           </Table>
         </div>
         <div
           class="lg:flex px-6 py-1.5 text-xs text-gray-400 bg-zinc-700 border-t border-gray-700"
         >
           <div class="flex justify-start mt-1.5 pb-1.5">
             <Pagination :links="offices.links" :meta="offices.meta" />
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
 offices: Object,
 currency: Object,
});

const currentDate = () => {
  return format(new Date(), 'yyyy-MM-dd');
};



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






const OnlyDebtors = ref(props.offices.OnlyDebtors);
const search = ref(props.offices.search);
const searchPhone = ref(props.offices.searchPhone);
const searchName = ref(props.offices.searchName);
const searchAddress = ref(props.offices.searchAddress);


const handleSearchUpdate = (value) => {
 search.value = value;
};

watch([search, OnlyDebtors , searchAddress, searchPhone, searchName ], debounce(([newSearch, newOnlyDebtors , newSearchAddress, newSearchPhone , newSearchName ]) => {
  // Using newSearch and newOnlyDebtors to ensure we're passing the updated values
  router.get(
    route("offices.index"),
    {
        search: newSearch,
        searchName: newSearchName,
        searchPhone: newSearchPhone,
      searchAddress : newSearchAddress,

      OnlyDebtors: newOnlyDebtors ? 'greater' : 'all',
    },
    {
      preserveState: true,
      replace: true,
    }
  );
}, 100));







const deleteoffice = (id) => {
   router.put(route('office.type_delete', { office: officeIdToDelete.value }), {
   preserveState: true,
 });
};


// this is for false to true
const showConfirmDeleteofficeModal = ref(false);

//this is for add id user you want
const officeIdToDelete = ref(null);

const officeIdToStore = ref(null);





// //thi is open by id
const confirmDeleteoffice = (id) => {
   officeIdToDelete.value = id;
   showConfirmDeleteofficeModal.value = true;
};

// // this is for close
const closeModal = () => {
   showConfirmDeleteofficeModal.value = false;
};

// //find data by id
const officeToDelete = computed(() => {
   return props.offices.data.find(office => office.id == officeIdToDelete.value);
});
const officeToStore = computed(() => {
   return props.offices.data.find(office => office.id == officeIdToStore.value);
});

const new_debt = computed(() => {
  if (officeToStore.value && !isNaN(form.amount_of_debt) &&  !isNaN(form.discount)) {
    return officeToStore.value.debt_office - form.amount_of_debt - form.discount;
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

};

function navigateToOffDebts(office) {
  router.get(route('offices.offdebts.index', office.id))
}






</script>
